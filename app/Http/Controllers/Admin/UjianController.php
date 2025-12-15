<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Soal;
use App\Models\Ujian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ujian.index');
    }

    public function data()
    {
        $ujians = Ujian::orderBy('created_at', 'desc');

        return datatables()
            ->eloquent($ujians)
            ->addIndexColumn()
            ->addColumn('nama', function ($ujians)
            {
                $text = '<a href="javascript:void(0);" onclick="detailForm(`' . route('admin.ujian.show', $ujians->id) . '`)">' . $ujians->nama;
                if ($ujians->isPublished) {
                    $text .= ' <span class="badge badge-success">Published</span>';
                }
                $text .= '</a>';
                return $text;
            })
            ->addColumn('waktu_pengerjaan', function ($ujians)
            {
                return Carbon::parse($ujians->waktu_mulai)->isoFormat('D MMMM Y HH:mm:ss') . ' - <br>' . Carbon::parse($ujians->waktu_akhir)->isoFormat('D MMMM Y HH:mm:ss');
            })
            ->addColumn('lama_pengerjaan', function ($ujians)
            {
                return '<span class="badge badge-warning">' . $ujians->lama_pengerjaan . '</span>';
            })
            ->addColumn('jenis_ujian', function ($ujians)
            {
                switch ($ujians->jenis_ujian) {
                    case 'mtk':
                        return 'Matematika';
                        break;
                    case 'skd':
                        return 'SKD';
                        break;
                    case 'lainnya':
                        return 'LAINNYA';
                        break;

                    default:
                        return 'LAINNYA';
                        break;
                }
            })
            ->addColumn('aksi', function ($ujians) {
                $text = '';
                if (!$ujians->isPublished && auth()->user()->hasRole('admin')) {
                    $text .= '<button onclick="editData(`' . route('admin.ujian.update', $ujians->id) . '`)" type="button" class="btn btn-outline-warning m-1"><i class="fa fa-edit"></i></button>
                    <button onclick="deleteData(`' . route('admin.ujian.destroy', $ujians->id) . '`)" type="button" class="btn btn-outline-danger m-1"><i class="fa fa-trash-alt"></i></button>';
                }
                
                // Add publish/unpublish button
                if (auth()->user()->hasRole('admin')) {
                    if ($ujians->isPublished) {
                        $text .= '<button onclick="togglePublish(`' . route('admin.ujian.publish', $ujians->id) . '`, false)" type="button" class="btn btn-outline-secondary m-1" title="Unpublish"><i class="fa fa-eye-slash"></i></button>';
                    } else {
                        $text .= '<button onclick="togglePublish(`' . route('admin.ujian.publish', $ujians->id) . '`, true)" type="button" class="btn btn-outline-primary m-1" title="Publish"><i class="fa fa-eye"></i></button>';
                    }
                }
                
                $text .= ' <a href="' . route('admin.ujian.soal.index', $ujians->id) . '" type="button" class="btn btn-outline-info m-1"><i class="fa fa-list"></i></a>';

                if (auth()->user()->hasRole('admin')) {
                    $text .= '<button onclick="duplicateUjian(`' . route('admin.ujian.duplicate', $ujians->id) . '`)" type="button" class="btn btn-outline-success m-1"><i class="fa fa-copy"></i></button>';
                }

                return $text;
            })
            ->rawColumns(['nama', 'aksi', 'lama_pengerjaan', 'waktu_pengerjaan'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'jenis_ujian' => 'required|in:skd,mtk,lainnya',
                'paket_ujian' => 'required|array|min:1',
                'paket_ujian.*' => 'exists:paket_ujian,id',
                'waktu_mulai' => 'required|string',
                'waktu_akhir' => 'required|string',
                'waktu_pengumuman' => 'required|string',
                'lama_pengerjaan' => 'required|integer|min:1',
                'jumlah_soal' => 'required|integer|min:1',
                'tipe_ujian' => 'required|in:1,2',
                'tampil_kunci' => 'required|in:0,1,2,3',
                'tampil_nilai' => 'required|in:0,1,2',
                'tampil_poin' => 'required|in:0,1',
                'random' => 'required|in:0,1',
                'random_pilihan' => 'required|in:0,1',
                'allow_pembahasan_during_test' => 'nullable|in:0,1',
                'pembahasan_access_limit' => 'nullable|integer|min:1',
            ], [
                'nama.required' => 'Nama ujian harus diisi',
                'jenis_ujian.required' => 'Jenis ujian harus dipilih',
                'waktu_mulai.required' => 'Waktu mulai ujian harus diisi',
                'waktu_akhir.required' => 'Waktu akhir ujian harus diisi',
                'waktu_pengumuman.required' => 'Waktu pengumuman harus diisi',
                'lama_pengerjaan.required' => 'Lama pengerjaan harus diisi',
                'lama_pengerjaan.min' => 'Lama pengerjaan minimal 1 menit',
                'jumlah_soal.required' => 'Jumlah soal harus diisi',
                'jumlah_soal.min' => 'Jumlah soal minimal 1',
            ]);

            $ujian = new Ujian();
            $ujian->nama = $request->nama;
            $ujian->jenis_ujian = $request->jenis_ujian;
            $ujian->deskripsi = $request->deskripsi;
            $ujian->peraturan = $request->peraturan;
            $ujian->waktu_mulai = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->waktu_mulai)));
            $ujian->waktu_akhir = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->waktu_akhir)));
            $ujian->waktu_pengumuman = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->waktu_pengumuman)));
            $ujian->lama_pengerjaan = $request->lama_pengerjaan;
            $ujian->jumlah_soal = $request->jumlah_soal;
            $ujian->tipe_ujian = $request->tipe_ujian;
            $ujian->tampil_kunci = $request->tampil_kunci;
            $ujian->tampil_nilai = $request->tampil_nilai;
            $ujian->tampil_poin = $request->tampil_poin;
            $ujian->random = $request->random;
            $ujian->random_pilihan = $request->random_pilihan;
            $ujian->allow_pembahasan_during_test = $request->allow_pembahasan_during_test ?? false;
            $ujian->pembahasan_access_limit = $request->pembahasan_access_limit;
            $ujian->pembahasan_access_reason = $request->pembahasan_access_reason;

            $ujian->save();
            
            // Sync packages
            $ujian->paketUjian()->sync($request->paket_ujian);

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Error creating ujian: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ujian = Ujian::with('soal')->find($id);
        $ujian['waktu_mulai'] = Carbon::parse($ujian['waktu_mulai'])->isoFormat('D MMMM Y HH:mm:ss');
        $ujian['waktu_akhir'] = Carbon::parse($ujian['waktu_akhir'])->isoFormat('D MMMM Y HH:mm:ss');
        $ujian['waktu_pengumuman'] = Carbon::parse($ujian['waktu_pengumuman'])->isoFormat('D MMMM Y HH:mm:ss');

        return response()->json($ujian);
    }

    public function preview($id) {
        $ujian = Ujian::findOrFail($id);

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis_ujian' => 'required',
            'paket_ujian' => 'required|array|min:1',
            'paket_ujian.*' => 'exists:paket_ujian,id',
            'waktu_mulai' => 'required',
            'waktu_akhir' => 'required',
            'waktu_pengumuman' => 'required',
            'lama_pengerjaan' => 'required|min:0',
            'jumlah_soal' => 'required|min:0',
            'tipe_ujian' => 'required',
            'tampil_kunci' => 'required',
            'tampil_nilai' => 'required',
            'tampil_poin' => 'required',
            'random' => 'required',
            'random_pilihan' => 'required',
            'allow_pembahasan_during_test' => 'nullable|in:0,1',
            'pembahasan_access_limit' => 'nullable|integer|min:1',
        ]);

        $ujian = Ujian::findOrFail($id);

        $ujian->nama = $request->nama;
        $ujian->jenis_ujian = $request->jenis_ujian;
        $ujian->deskripsi = $request->deskripsi;
        $ujian->peraturan = $request->peraturan;
        $ujian->waktu_mulai = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->waktu_mulai)));
        $ujian->waktu_akhir = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->waktu_akhir)));
        $ujian->waktu_pengumuman = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $request->waktu_pengumuman)));
        $ujian->lama_pengerjaan = $request->lama_pengerjaan;
        $ujian->jumlah_soal = $request->jumlah_soal;
        $ujian->tipe_ujian = $request->tipe_ujian;
        $ujian->tampil_kunci = $request->tampil_kunci;
        $ujian->tampil_nilai = $request->tampil_nilai;
        $ujian->tampil_poin = $request->tampil_poin;
        $ujian->random = $request->random;
        $ujian->random_pilihan = $request->random_pilihan;
        $ujian->allow_pembahasan_during_test = $request->allow_pembahasan_during_test ?? false;
        $ujian->pembahasan_access_limit = $request->pembahasan_access_limit;
        $ujian->pembahasan_access_reason = $request->pembahasan_access_reason;
        $ujian->update();
        
        // Sync packages
        $ujian->paketUjian()->sync($request->paket_ujian);

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $ujian = Ujian::findOrFail($id);

            // Check if ujian is published
            if ($ujian->isPublished) {
                return response()->json([
                    'message' => 'Tidak dapat menghapus ujian yang sudah dipublish. Silakan unpublish terlebih dahulu.'
                ], 422);
            }

            // Check if ujian has active participants (status > 0 means started or completed)
            $hasActiveParticipants = $ujian->ujianUser()->where('status', '>', 0)->exists();

            if ($hasActiveParticipants) {
                return response()->json([
                    'message' => 'Tidak dapat menghapus ujian karena sudah memiliki peserta yang aktif. Ujian hanya dapat dihapus jika belum ada peserta yang memulai ujian.'
                ], 422);
            }

            // Delete related data in proper order
            // First delete jawaban_peserta for all ujian_user
            foreach ($ujian->ujianUser as $ujianUser) {
                $ujianUser->jawabanPeserta()->delete();
            }
            // Then delete ujian_user
            $ujian->ujianUser()->delete();
            // Then delete soal
            $ujian->soal()->delete();
            // Finally delete ujian
            $ujian->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            \Log::error('Error deleting ujian: ' . $e->getMessage());
            return response()->json([
                'message' => 'Tidak dapat menghapus data. Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function publish($id)
    {
        $ujian = Ujian::with('soal')->findorFail($id);
        
        // Jika ujian sudah dipublish, langsung unpublish tanpa cek jumlah soal
        if ($ujian->isPublished) {
            $ujian->isPublished = 0;
            $ujian->update();
            return response()->json('Ujian berhasil di-unpublish', 200);
        }
        
        // Jika belum dipublish, cek jumlah soal terlebih dahulu
        if ($ujian->soal->count() == $ujian->jumlah_soal) {
            $ujian->isPublished = 1;
            $ujian->update();
            return response()->json('Ujian berhasil dipublish', 200);
        }
        
        return response()->json('Tidak dapat mempublish. Jumlah soal tidak sesuai (Ada: ' . $ujian->soal->count() . ', Dibutuhkan: ' . $ujian->jumlah_soal . ')', 300);
    }

    public function duplicate($id_ujian) {
        $ujian = Ujian::with('soal', 'soal.jawaban')->findOrFail($id_ujian);

        $duplicateUjian = $ujian->replicate();
        $duplicateUjian->nama  = $ujian->nama . '-DUPLICATE';
        $duplicateUjian->isPublished = false;
        $duplicateUjian->save();

        foreach ($duplicateUjian->soal as $soal) {
            $duplicateSoal = $soal->replicate();
            $duplicateSoal->ujian_id = $duplicateUjian->id;
            $duplicateSoal->save();
            foreach ($soal->jawaban as $jawaban) {
                $duplicateJawaban = $jawaban->replicate();
                $duplicateJawaban->soal_id = $duplicateSoal->id;
                $duplicateJawaban->save();
                if ($jawaban->id == $duplicateSoal->kunci_jawaban) {
                    $duplicateSoal->kunci_jawaban = $duplicateJawaban->id;
                    $duplicateSoal->save();
                }
            }
        }
        return response()->json('Ujian berhasil diduplikat', 200);
    }
    
    /**
     * Get packages associated with an exam
     */
    public function getPackages($id)
    {
        $ujian = Ujian::findOrFail($id);
        $packageIds = $ujian->paketUjian()->pluck('paket_ujian.id')->toArray();
        
        return response()->json($packageIds);
    }
}
