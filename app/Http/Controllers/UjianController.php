<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Jawaban;
use App\Models\Session;
use App\Models\Pembelian;
use App\Models\UjianUser;
use App\Models\PaketUjian;
use Illuminate\Http\Request;
use App\Models\JawabanPeserta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class UjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id = null)
    {
        $tryout = new Collection();
        $data = collect();

        // Get verified purchases only
        $pembelianQuery = Pembelian::with([
            'paketUjian.ujian' => function ($query) {
                $query->where('isPublished', 1)->orderBy('nama', 'asc');
            },
            'paketUjian.ujian.ujianUser' => function ($query) {
                $query->where('user_id', auth()->id());
            },
        ])
        ->forUser(auth()->id())
        ->verified()
        ->latest('updated_at');

        if ($id) {
            $pembelianQuery->where('paket_id', $id);
        }
        
        $data = $pembelianQuery->get();

        foreach ($data as $dt) {
            // Only add if paketUjian exists and has ujian
            if ($dt->paketUjian && $dt->paketUjian->ujian) {
                foreach ($dt->paketUjian->ujian as $ujian) {
                    $ujian['id_paket'] = $dt->paketUjian->id;
                    $ujian['nama_paket'] = $dt->paketUjian->nama;
                    $tryout->push($ujian);
                }
            }
        }
        
        $tryout = $tryout->unique('id')->sortBy('nama');

        return view('views_user.ujian.tryout', compact('data', 'tryout'));
    }

    /**
     * Check if user has access to discussion during test
     */
    private function canAccessPembahasanDuringTest($ujian, $ujianUser)
    {
        // Check if discussion is allowed during test for this ujian
        if (!$ujian->allow_pembahasan_during_test) {
            return false;
        }

        // Check if user has access limit
        $accessCount = JawabanPeserta::where('ujian_user_id', $ujianUser->id)
            ->whereNotNull('accessed_pembahasan_at')
            ->count();

        if ($ujian->pembahasan_access_limit && $accessCount >= $ujian->pembahasan_access_limit) {
            return false;
        }

        return true;
    }

    /**
     * Show discussion for a specific question during test
     */
    public function showPembahasanDuringTest($ujianId, $soalId)
    {
        $ujianUser = UjianUser::with('ujian')->findOrFail($ujianId);
        
        if ($ujianUser->user_id != auth()->user()->id) {
            abort(404);
        }

        if ($ujianUser->status == 2) {
            abort(403, 'Ujian sudah selesai');
        }

        // Check if user has access to discussion during test
        if (!$this->canAccessPembahasanDuringTest($ujianUser->ujian, $ujianUser)) {
            return response()->json([
                'error' => true,
                'message' => 'Anda tidak memiliki akses ke pembahasan saat ini. Hubungi admin jika mengalami kesulitan.'
            ], 403);
        }

        $soal = Soal::with('jawaban')
            ->where('id', $soalId)
            ->where('ujian_id', $ujianId)
            ->first();

        if (!$soal) {
            abort(404);
        }

        // Mark that user accessed discussion
        JawabanPeserta::where('ujian_user_id', $ujianUser->id)
            ->where('soal_id', $soalId)
            ->update(['accessed_pembahasan_at' => Carbon::now()]);

        return response()->json([
            'success' => true,
            'soal' => $soal->soal,
            'pembahasan' => $soal->pembahasan,
            'jawaban' => $soal->jawaban->map(function($jawaban, $key) use ($soal) {
                return [
                    'id' => $jawaban->id,
                    'jawaban' => $jawaban->jawaban,
                    'is_correct' => $jawaban->id == $soal->kunci_jawaban,
                    'option' => chr($key + 65)
                ];
            }),
            'kunci_jawaban' => $soal->kunci_jawaban
        ]);
    }

    /**
     * Get discussion access status for current user
     */
    public function getPembahasanAccessStatus($ujianId)
    {
        $ujianUser = UjianUser::with('ujian')->findOrFail($ujianId);
        
        if ($ujianUser->user_id != auth()->user()->id) {
            abort(404);
        }

        $ujian = $ujianUser->ujian;
        $accessCount = JawabanPeserta::where('ujian_user_id', $ujianUser->id)
            ->whereNotNull('accessed_pembahasan_at')
            ->count();

        $limit = $ujian->pembahasan_access_limit;
        $remaining = $limit ? max(0, $limit - $accessCount) : null;

        return response()->json([
            'allowed' => $ujian->allow_pembahasan_during_test,
            'limit' => $limit,
            'used' => $accessCount,
            'remaining' => $remaining,
            'reason' => $ujian->pembahasan_access_reason
        ]);
    }

    public function ujian($id) {
        $ujianUser = UjianUser::with('ujian')->findOrFail($id);
        if ($ujianUser->user_id != auth()->user()->id) {
            abort(404);
        }

        if ($ujianUser->status == 2) {
            // Redirect to results page instead of showing error
            return redirect()->route('tryout.nilai', $ujianUser->ujian_id);
        }

        $preparation = JawabanPeserta::with(['soal', 'soal.jawaban' => function ($q) use ($ujianUser)
        {
            if ($ujianUser->ujian->random_pilihan == 1) {
                $q->inRandomOrder();
            }
        }, 'soal.ujian'])
                ->where('ujian_user_id', $id)
                ->whereHas('soal'); // Only include records with valid soal relationship
        $ragu_ragu = $preparation->pluck('ragu_ragu');
        $rekap_jawaban = $preparation->pluck('jawaban_id');
        $soal = $preparation->paginate(1, ['*'], 'no');
        
        // Pass ujian separately to avoid null reference errors
        $ujian = $ujianUser->ujian;
        
        return view('views_user.ujian.index', compact('soal', 'ragu_ragu', 'ujianUser', 'rekap_jawaban', 'ujian'));
    }

    public function pembahasan($id) {
        $ujian = Ujian::with('ujianUser')->findOrFail($id);
        $ujianUser = UjianUser::where('ujian_id', $id)->where('user_id', auth()->user()->id)->first();
        // Allow access if user has completed the exam (status == 2) or based on existing rules
        $hasCompletedExam = $ujianUser && $ujianUser->status == 2;
        if (!($hasCompletedExam || ($ujian->tampil_kunci == 1 && $ujianUser) || ($ujian->tampil_kunci == 2 && Carbon::now() > $ujian->waktu_akhir) || ($ujian->tampil_kunci == 3 && Carbon::now() > $ujian->waktu_pengumuman))) {
            abort(403, 'ERROR');
        }

        if ($ujian->jenis_ujian == 'skd') {
            $preparation = Soal::with('jawaban')->where('ujian_id', $id)
                        ->whereIn('jenis_soal', ['twk', 'tiu', 'tkp'])
                        ->orderByRaw('FIELD(jenis_soal,"twk", "tiu", "tkp")')
                        ->orderBy('created_at', 'asc');
        } else {
            $preparation = Soal::with('jawaban')->where('ujian_id', $id);
        }
        // $preparation = Soal::with('jawaban')->where('ujian_id', $id);
        $soal = $preparation->paginate(1, ['*'], 'no');
        return view('views_user.ujian.pembahasan', compact('soal', 'ujian'));
    }

    /**
     * Show discussion for a specific question after test completion
     */
    public function showPembahasanAfterTest($ujianId, $soalId)
    {
        $ujian = Ujian::findOrFail($ujianId);
        $ujianUser = UjianUser::where('ujian_id', $ujianId)->where('user_id', auth()->user()->id)->first();

        // Allow access if user has completed the exam (status == 2) or based on existing rules
        $hasCompletedExam = $ujianUser && $ujianUser->status == 2;
        if (!($hasCompletedExam || ($ujian->tampil_kunci == 1 && $ujianUser) || ($ujian->tampil_kunci == 2 && Carbon::now() > $ujian->waktu_akhir) || ($ujian->tampil_kunci == 3 && Carbon::now() > $ujian->waktu_pengumuman))) {
            return response()->json([
                'error' => true,
                'message' => 'Anda tidak memiliki akses ke pembahasan saat ini.'
            ], 403);
        }

        $soal = Soal::with('jawaban')
            ->where('id', $soalId)
            ->where('ujian_id', $ujianId)
            ->first();

        if (!$soal) {
            abort(404);
        }

        return response()->json([
            'success' => true,
            'soal' => $soal->soal,
            'pembahasan' => $soal->pembahasan,
            'jawaban' => $soal->jawaban->map(function($jawaban, $key) use ($soal) {
                return [
                    'id' => $jawaban->id,
                    'jawaban' => $jawaban->jawaban,
                    'is_correct' => $jawaban->id == $soal->kunci_jawaban,
                    'option' => chr($key + 65)
                ];
            }),
            'kunci_jawaban' => $soal->kunci_jawaban
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jawaban_peserta' => 'required',
        ]);

        $jawaban_peserta = JawabanPeserta::with('soal')->findOrFail($request->jawaban_peserta);
        if ($jawaban_peserta === null) {
            $store = new JawabanPeserta();
            $store->pembelian_id = $request->pembelian_id;
            $store->soal_id = $request->soal_id;
            $store->jawaban_id = $request->key;
            $store->save();
        } else {
            if ($request->key == NULL) {
                $jawaban_peserta->jawaban_id = null;
                $jawaban_peserta->poin = $jawaban_peserta->soal->poin_kosong;
                $jawaban_peserta->update();
            } else {
                if ($jawaban_peserta->soal->jenis_soal == 'tkp') {
                    $jawaban = Jawaban::findOrFail($request->key);
                    $jawaban_peserta->poin = $jawaban->point;
                } else {
                    if ($request->key == $jawaban_peserta->soal->kunci_jawaban) {
                        $jawaban_peserta->poin = $jawaban_peserta->soal->poin_benar;
                    } else {
                        $jawaban_peserta->poin = $jawaban_peserta->soal->poin_salah;
                    }
                }

                $jawaban_peserta->jawaban_id = $request->key;
                $jawaban_peserta->update();
            }

        }

        return response()->json('Data berhasil disimpan', 200);
    }

    public function storeRagu(Request $request, $id)
    {
        $jawaban = JawabanPeserta::find($id);
        $jawaban->ragu_ragu = $jawaban->ragu_ragu == 1 ? 0 : 1;
        $jawaban->update();

        return response()->json($jawaban, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ujian = Ujian::with(['ujianUser' => function ($query) {
            return $query->where('is_first', 1)->where('user_id', auth()->user()->id)->first();
        }], 'paketUjian')->find($id);

        if ($ujian->isPublished != 1) {
            abort(404);
        }

        // Check if user has verified purchase for this tryout's package
        $hasAccess = $ujian->paketUjian()
                    ->whereHas('pembelian', function ($query) {
                        $query->forUser(auth()->id())->verified();
                    })
                    ->exists();
        
        $betweenTime = Carbon::now()->between($ujian->waktu_mulai, $ujian->waktu_akhir);
        
        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke tryout ini. Silakan beli paket terlebih dahulu dan pastikan pembayaran sudah diverifikasi.');
        }
        
        return view('views_user.ujian.show', compact('ujian', 'betweenTime'));
    }

    public function sessionDestroy() {
        $session = Session::where('user_id', auth()->user()->id)
                    ->where('id', '!=', session()->getId());
        $session->delete();

        return response(200);
    }

    private function generateSoal($id) {
        $ujianUser = UjianUser::with('ujian')->findOrFail($id);
        if ($ujianUser->ujian->jenis_ujian == 'skd') {
            $twk = Soal::where('ujian_id', $ujianUser->ujian->id)
                    ->where('jenis_soal', 'twk')
                    ->limit(30)
                    ->get();
            $tiu = Soal::where('ujian_id', $ujianUser->ujian->id)
                    ->where('jenis_soal', 'tiu')
                    ->limit(35)
                    ->get();
            $tkp = Soal::where('ujian_id', $ujianUser->ujian->id)
                    ->where('jenis_soal', 'tkp')
                    ->limit(45)
                    ->get();
            if ($ujianUser->ujian->random) {
                $twk = $twk->shuffle();
                $tiu = $tiu->shuffle();
                $tkp = $tkp->shuffle();
            }
            $soal = new Collection();
            $soal = $soal->merge($twk);
            $soal = $soal->merge($tiu);
            $soal = $soal->merge($tkp);
        } else {
            $soal = Soal::where('ujian_id', $ujianUser->ujian->id)
                    ->limit($ujianUser->ujian->jumlah_soal)
                    ->get();
            $soal = $ujianUser->ujian->random ? $soal->shuffle() : $soal;
        }
        return $soal;
    }

    public function mulaiUjian($id)
    {
        $ujian = Ujian::with('ujianUser')->findOrFail($id);
        $betweenTime = Carbon::now()->between($ujian->waktu_mulai, $ujian->waktu_akhir);

        $session = Session::where('user_id', auth()->user()->id)->get();
        if ($session->count() > 1) {
            return response()->json('session limit', 200);
        }

        $ujianUser = UjianUser::with('ujian')
                    ->where('ujian_id', $id)
                    ->where('user_id', auth()->user()->id)
                    ->latest()
                    ->first();

        if ($ujianUser == NULL) {
            $createUjianUser = UjianUser::create([
                'ujian_id' => $id,
                'user_id' => auth()->user()->id,
                'status' => 0,
                'is_first' => 1,
            ]);
            $ujianUser = $createUjianUser;

            $soal = $this->generateSoal($createUjianUser->id);
        } else {
            if ($ujianUser->ujian->tipe_ujian == 1) {
                return response()->json('OK|'.$ujianUser->id, 200);
            } else if($ujianUser->ujian->tipe_ujian == 2) {
                if ($ujianUser->status == 2) {
                    $createUjianUser = UjianUser::create([
                        'ujian_id' => $id,
                        'user_id' => auth()->user()->id,
                        'status' => 0,
                    ]);
                    $ujianUser = $createUjianUser;

                    $soal = $this->generateSoal($createUjianUser->id);
                } else {
                    return response()->json('OK|'.$ujianUser->id, 200);
                }
            }
        }

        if ($ujianUser->status != 1) {
            $ujianUser->status = 1;
            $ujianUser->waktu_mulai = Carbon::now();
            $ujianUser->waktu_akhir = Carbon::parse($ujianUser->waktu_mulai)->addMinutes($ujianUser->ujian->lama_pengerjaan);
            $ujianUser->update();

            foreach ($soal as $key => $item) {
                $store = new JawabanPeserta();
                $store->ujian_user_id = $ujianUser->id;
                $store->soal_id = $item->id;
                $store->poin = $item->poin_kosong;
                $store->save();
            }
        }
        return response()->json('OK|'.$ujianUser->id, 200);
    }

    public function selesaiUjian($id)
    {
        $ujianUser = UjianUser::with('ujian', 'jawabanPeserta', 'jawabanPeserta.soal')->findOrFail($id);

        if ($ujianUser->status == 1) {
            $ujianUser->status = 2;
            $ujianUser->waktu_akhir = date('Y-m-d H:i:s');
            $ujianUser->nilai = $ujianUser->jawabanPeserta->sum('poin');
            if ($ujianUser->ujian->jenis_ujian == 'skd') {
                $ujianUser->nilai_twk = $ujianUser->jawabanPeserta->splice(0,30)->sum('poin');
                $ujianUser->nilai_tiu = $ujianUser->jawabanPeserta->splice(0,35)->sum('poin');
                $ujianUser->nilai_tkp = $ujianUser->jawabanPeserta->splice(0,45)->sum('poin');
            } else {
                $jml_benar = 0;
                $jml_salah = 0;
                foreach ($ujianUser->jawabanPeserta as $item) {
                    if ($item->jawaban_id == NULL) {
                        continue;
                    }

                    if ($item->jawaban_id === $item->soal->kunci_jawaban) {
                        $jml_benar += 1;
                    } else {
                        $jml_salah += 1;
                    }
                }

                $ujianUser->jml_benar = $jml_benar;
                $ujianUser->jml_kosong = $ujianUser->jawabanPeserta->where('jawaban_id', NULL)->count();
                $ujianUser->jml_salah = $jml_salah;
            }

            $ujianUser->update();
        }

        return response()->json('Data berhasil disimpan', 200);
    }

    public function nilai($id)
    {
        $ujian = Ujian::with(['ujianUser' => function($query) {
                            $query->where('user_id', auth()->user()->id);
                        }, 'ujianUser.jawabanPeserta', 'ujianUser.jawabanPeserta.soal.jawaban'])
                    ->findOrFail($id);

        // Get the completed ujianUser for current user
        $currentUserUjian = $ujian->ujianUser->where('status', 2)->first();

        // If no completed ujianUser found for this user, deny access
        if (!$currentUserUjian) {
            abort(403, 'Anda belum menyelesaikan tryout ini');
        }

        // Allow access since exam is completed
        $canViewNilai = true;

        $user = User::with('usersDetail')->find(auth()->user()->id);

        $ujianUser = UjianUser::with('user.usersDetail')
                        ->where('ujian_id', $id)
                        ->where('is_first', 1)
                        ->orderBy('nilai', 'desc')
                        ->get();
        
        // Filter by prodi only if usersDetail exists and prodi is set
        if ($user->usersDetail && $user->usersDetail->prodi) {
            $ujianUser = $ujianUser->where('user.usersDetail.prodi', $user->usersDetail->prodi)->values();
        } else {
            $ujianUser = $ujianUser->values();
        }
        foreach ($ujianUser as $user) {
            if ($ujian->jenis_ujian == 'skd') {
                $user->status_kelulusan = ($user->nilai_twk >= 65 && $user->nilai_tiu >= 80 && $user->nilai_tkp >= 166);
            } else if($ujian->jenis_ujian == 'mtk') {
                $user->status_kelulusan = ($user->nilai >= 65);
            }
        }
        $ujianUser = $ujianUser->sortByDesc('status_kelulusan')->values();
        $totalRank = $ujianUser->count();
        $rankUser = $ujianUser->where('user_id', auth()->user()->id);
        $rank = $rankUser->isNotEmpty() ? $rankUser->keys()->first() + 1 : 0;

        // Filter by penempatan only if usersDetail exists and penempatan is set
        if (auth()->user()->usersDetail && auth()->user()->usersDetail->penempatan) {
            $userFormasi = $ujianUser->where('user.usersDetail.penempatan', auth()->user()->usersDetail->penempatan)->values();
        } else {
            $userFormasi = $ujianUser->values();
        }
        $totalRankFormasi = $userFormasi->count();
        $rankUserFormasi = $userFormasi->where('user_id', auth()->user()->id);
        $rankUserFormasi = $userFormasi->where('user_id', auth()->user()->id);
        $rankUserFormasi = $userFormasi->isNotEmpty() ? $userFormasi->where('user_id', auth()->user()->id)->keys()->first() + 1 : 0;

        $dataUjianUser = UjianUser::where('ujian_id', $id)->where('user_id', auth()->user()->id)->get();
        $dates = $dataUjianUser->pluck('created_at');
        $dataUjianUser->tanggal = $dates->map(function ($date) {
            return \Carbon\Carbon::parse($date)->isoFormat('D MMMM Y HH:mm:ss');
        });
        return view('views_user.nilai.index', compact('ujian', 'currentUserUjian', 'ujianUser', 'userFormasi', 'totalRank', 'rank', 'totalRankFormasi', 'rankUserFormasi', 'dataUjianUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ujian $ujian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ujian $ujian)
    {
        //
    }

    /**
     * Show global ranking for completed tryouts
     */
    public function rankingGlobal()
    {
        // Get all completed exams for the current user
        $completedExams = UjianUser::with(['ujian', 'user'])
            ->where('user_id', auth()->user()->id)
            ->where('status', 2) // completed
            ->where('is_first', 1) // only first attempts
            ->orderBy('nilai', 'desc')
            ->get();

        // Calculate total score across all completed exams
        $totalScore = $completedExams->sum('nilai');
        $totalExams = $completedExams->count();

        // Get rankings for each exam type
        $examRankings = [];
        foreach ($completedExams as $examUser) {
            $ranking = UjianUser::where('ujian_id', $examUser->ujian_id)
                ->where('status', 2)
                ->where('is_first', 1)
                ->orderBy('nilai', 'desc')
                ->pluck('user_id')
                ->search(auth()->user()->id) + 1;

            $examRankings[] = [
                'exam' => $examUser->ujian,
                'score' => $examUser->nilai,
                'rank' => $ranking,
                'total_participants' => UjianUser::where('ujian_id', $examUser->ujian_id)
                    ->where('status', 2)
                    ->where('is_first', 1)
                    ->count()
            ];
        }

        return view('views_user.ranking.global', compact('completedExams', 'totalScore', 'totalExams', 'examRankings'));
    }

    /**
     * Show progress chart for completed tryouts
     */
    public function progresNilai()
    {
        // Get all completed exams for the current user
        $completedExams = UjianUser::with(['ujian'])
            ->where('user_id', auth()->user()->id)
            ->where('status', 2) // completed
            ->where('is_first', 1) // only first attempts
            ->orderBy('created_at', 'asc')
            ->get();

        // Calculate statistics
        $totalScore = $completedExams->sum('nilai');
        $totalExams = $completedExams->count();
        $averageScore = $totalExams > 0 ? round($totalScore / $totalExams, 1) : 0;

        // Get scores and dates for chart
        $scores = $completedExams->pluck('nilai');
        $dates = $completedExams->pluck('created_at');
        $examNames = $completedExams->pluck('ujian.nama');

        return view('views_user.progres.nilai', compact('completedExams', 'totalScore', 'totalExams', 'averageScore', 'scores', 'dates', 'examNames'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ujian $ujian)
    {
        //
    }
}
