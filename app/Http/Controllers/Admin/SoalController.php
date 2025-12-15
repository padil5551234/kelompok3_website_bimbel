<?php

namespace App\Http\Controllers\Admin;

use App\Models\Soal;
use App\Models\Ujian;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $ujian = Ujian::with('soal')->find($id);
        if (! $ujian) {
            abort(404);
        }
        if ($ujian->jenis_ujian == 'skd') {
            $twk = $ujian->soal->where('jenis_soal', 'twk');
            $tiu = $ujian->soal->where('jenis_soal', 'tiu');
            $tkp = $ujian->soal->where('jenis_soal', 'tkp');
            return view('admin.soal.index', compact('ujian', 'twk', 'tiu', 'tkp'));
        }
        return view('admin.soal.index', compact('ujian'));
    }

    public function data(Request $request, $id)
    {
        $soals = Soal::where('ujian_id', $id)
                ->with('jawaban', 'ujian')
                ->orderBy('created_at', 'asc');

        return datatables()
            ->of($soals)
            ->addIndexColumn()
            ->addColumn('soal', function ($soals)
            {
                $soal = $soals->soal . '</br><table>';
                foreach ($soals->jawaban as $key => $jawaban) {
                    $soal .= '<tr><td style="border: none">';
                    if ($jawaban->id == $soals->kunci_jawaban) {
                        $soal .= '<span class="badge badge-success">' . chr($key+65) . '. </span>';
                    } else {
                        $soal .= chr($key+65) . '.';
                    }

                    if ($soals->jenis_soal == 'tkp') {
                        $soal .= '</td><td style="border: none"><font color="green">(' . $jawaban->point . ')</font> ' . $jawaban->jawaban . '</td></tr>';
                    } else {
                        $soal .= '</td><td style="border: none">' . $jawaban->jawaban . '</td></tr>';
                    }
                }
                $soal .= '</table>';

                return $soal;
            })
            ->addColumn('jenis_soal', function ($soals)
            {
                return strtoupper($soals->jenis_soal);
            })
            ->addColumn('point', function ($soals)
            {
                if ($soals->jenis_soal == 'tkp') {
                    return '-';
                } else {
                    return (
                        '<span class="badge badge-success">Benar: ' . $soals->poin_benar . '</span>' .
                        '<span class="badge badge-info">Kosong: ' . $soals->poin_kosong . '</span>' .
                        '<span class="badge badge-danger">Salah: ' . $soals->poin_salah . '</span>'
                    );
                }
            })
            ->addColumn('aksi', function ($soals) {
                if ($soals->ujian->isPublished) {
                    return '<span class="badge badge-success">Published</span>';
                } else {
                    return '
                        <a href="' . route('admin.soal.edit', $soals->id) . '" type="button" class="btn btn-outline-warning"><i class="fa fa-edit"></i></a>
                        <button onclick="deleteData(`' .
                        route('admin.soal.destroy', $soals->id) .
                        '`)" type="button" class="btn btn-outline-danger"><i class="fa fa-trash-alt"></i></button>
                    ';
                }
            })
            ->filter(function ($soals) use ($request) {
                if ($request->get('jenis_soal') == 'twk' || $request->get('jenis_soal') == 'tiu' || $request->get('jenis_soal') == 'tkp') {
                    $soals->where('jenis_soal', $request->jenis_soal)->orderBy('created_at', 'asc');
                }
                if (!empty($request->get('search'))) {
                    $soals->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->orWhere('soal', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['aksi', 'soal', 'point'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $soal = new Soal();
        $ujian = Ujian::with('soal')->find($id);
        if (! $ujian) {
            abort(404);
        }
        $action = 'admin.ujian.soal.store';
        return view('admin.soal.form', compact('ujian', 'soal', 'action'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'jenis_soal' => 'required_if:jenis_ujian,skd',
                'soal' => 'required',
                'jawaban.*' => 'required',
                'kunci_jawaban' => 'required_unless:jenis_soal,tkp',
                'point.*' => 'required_if:jenis_soal,tkp',
                'nilai_benar' => 'required_unless:jenis_soal,tkp|numeric',
                'nilai_kosong' => 'required_unless:jenis_soal,tkp|numeric',
                'nilai_salah' => 'required_unless:jenis_soal,tkp|numeric',
            ], [
                'jenis_soal.required_if' => 'Jenis soal tidak boleh kosong.',
                'soal.required' => 'Soal tidak boleh kosong.',
                'jawaban.*.required' => 'Jawaban tidak boleh kosong.',
                'kunci_jawaban.required_unless' => 'Kunci jawaban tidak boleh kosong.',
                'point.*.required_if' => 'Point tidak boleh kosong.',
                'nilai_benar.required_unless' => 'Nilai benar tidak boleh kosong.',
                'nilai_benar.numeric' => 'Nilai benar harus berupa angka.',
                'nilai_kosong.required_unless' => 'Nilai kosong tidak boleh kosong.',
                'nilai_kosong.numeric' => 'Nilai kosong harus berupa angka.',
                'nilai_salah.required_unless' => 'Nilai salah tidak boleh kosong.',
                'nilai_salah.numeric' => 'Nilai salah harus berupa angka.',
            ]);

            $ujian = Ujian::with('soal')->findOrFail($id);
            
            if ($ujian->jumlah_soal == $ujian->soal->count()) {
                return redirect()->back()->withInput()->with('error','Soal sudah penuh.');
            }

            if ($ujian->jenis_ujian == 'skd') {
                if ($request->jenis_soal == 'twk') {
                    if ($ujian->soal->where('jenis_soal', $request->jenis_soal)->count() == 30) {
                        return redirect()->back()->withInput()->with('error','Soal TWK sudah penuh (30 soal).');
                    }
                } elseif ($request->jenis_soal == 'tiu') {
                    if ($ujian->soal->where('jenis_soal', $request->jenis_soal)->count() == 35) {
                        return redirect()->back()->withInput()->with('error','Soal TIU sudah penuh (35 soal).');
                    }
                } elseif ($request->jenis_soal == 'tkp') {
                    if ($ujian->soal->where('jenis_soal', $request->jenis_soal)->count() == 45) {
                        return redirect()->back()->withInput()->with('error','Soal TKP sudah penuh (45 soal).');
                    }
                }
            }

            $soal = new Soal();
            $soal->ujian_id = $id;
            $soal->soal = $request->soal;
            $soal->jenis_soal = $request->jenis_ujian == 'skd' ? $request->jenis_soal : null;
            
            // Set poin untuk soal non-TKP
            if ($request->jenis_soal != 'tkp') {
                $soal->poin_benar = $request->nilai_benar ?? 5;
                $soal->poin_salah = $request->nilai_salah ?? 0;
                $soal->poin_kosong = $request->nilai_kosong ?? 0;
            } else {
                // Untuk TKP, set default 0
                $soal->poin_benar = 0;
                $soal->poin_salah = 0;
                $soal->poin_kosong = 0;
            }
            
            $soal->pembahasan = $request->pembahasan;
            
            if (!$soal->save()) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan soal. Silakan coba lagi.');
            }

            // Buat jawaban dan set kunci jawaban
            foreach ($request->jawaban as $key => $jawabanText) {
                $newJawaban = new Jawaban();
                $newJawaban->soal_id = $soal->id;
                $newJawaban->jawaban = $jawabanText;
                
                // Set point untuk TKP
                if ($request->jenis_soal == 'tkp') {
                    $newJawaban->point = $request->point[$key] ?? 0;
                } else {
                    $newJawaban->point = 0;
                }
                
                $newJawaban->save();

                // Set kunci jawaban untuk non-TKP (berdasarkan index)
                if ($request->jenis_soal != 'tkp') {
                    if ($key == $request->kunci_jawaban) {
                        $soal->kunci_jawaban = $newJawaban->id;
                        $soal->save();
                    }
                }
            }

            return redirect()->route('admin.ujian.soal.index', $id)->with('message','Data soal berhasil disimpan');
            
        } catch (\Exception $e) {
            \Log::error('Error storing soal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan soal: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Soal $soal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $soal = Soal::with('ujian', 'jawaban')->find($id);
        if (! $soal) {
            abort(404);
        }
        if ($soal->ujian->isPublished) {
            return redirect()->route('admin.ujian.soal.index', $soal->ujian_id);
        }
        $ujian = $soal->ujian;
        $action = 'admin.soal.update';
        return view('admin.soal.form', compact('soal', 'ujian', 'action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_soal' => 'required_if:jenis_ujian,skd',
            'soal' => 'required',
            'jawaban.*' => 'required',
            'kunci_jawaban' => 'required_unless:jenis_soal,tkp',
            'point.*' => 'required_if:jenis_soal,tkp',
        ], [
            'jenis_soal.required_if' => 'Jenis soal tidak boleh kosong.',
            'soal.required' => 'Soal tidak boleh kosong.',
            'jawaban.*.required' => 'Jawaban tidak boleh kosong.',
            'kunci_jawaban.required_unless' => 'Kunci jawaban tidak boleh kosong.',
            'point.*.required_if' => 'Point tidak boleh kosong.'
        ]);

        $soal = Soal::with('jawaban')->findOrFail($id);
        $soal->soal = $request->soal;
        $soal->jenis_soal = $request->jenis_ujian == 'skd' ? $request->jenis_soal : null;
        $soal->pembahasan = $request->pembahasan;
        
        // Handle poin untuk soal non-TKP
        if ($request->jenis_soal != 'tkp') {
            $soal->poin_benar = $request->nilai_benar ?? 0;
            $soal->poin_salah = $request->nilai_salah ?? 0;
            $soal->poin_kosong = $request->nilai_kosong ?? 0;
            // Kunci jawaban harus berupa ID jawaban, bukan index
            if ($request->kunci_jawaban) {
                $soal->kunci_jawaban = $request->kunci_jawaban;
            }
        } else {
            // Untuk TKP, tidak ada kunci jawaban tunggal
            $soal->kunci_jawaban = null;
        }
        
        $soal->update();

        // Update jawaban
        foreach ($request->id_jawaban as $key => $id_jawaban) {
            $jawaban = Jawaban::findOrFail($id_jawaban);
            $jawaban->jawaban = $request->jawaban[$key] ?? '';
            
            // Update point untuk TKP
            if ($request->jenis_soal == 'tkp') {
                $jawaban->point = $request->point[$key] ?? 0;
            } else {
                $jawaban->point = 0;
            }
            
            $jawaban->update();
        }

        return redirect()->route('admin.ujian.soal.index', $soal->ujian_id)->with('message','Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $soal = Soal::find($id);
        $soal->delete();

        return response(null, 204);
    }

    /**
     * Summernote image upload handler for Soal fields (soal, jawaban, pembahasan).
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp,svg|max:5120',
        ], [
            'image.required' => 'Gambar wajib diunggah.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, jpg, png, gif, webp, atau svg.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $path = $request->file('image')->store('soal', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    /**
     * Show bulk import form
     */
    public function bulkImportForm($id)
    {
        $ujian = Ujian::with('soal')->find($id);
        if (!$ujian) {
            abort(404);
        }
        return view('admin.soal.bulk-import', compact('ujian'));
    }

    /**
     * Process bulk import
     */
    public function bulkImportStore(Request $request, $id)
    {
        $request->validate([
            'bulk_data' => 'required|string',
        ], [
            'bulk_data.required' => 'Data soal tidak boleh kosong.',
        ]);

        $ujian = Ujian::with('soal')->findOrFail($id);
        $bulkData = $request->bulk_data;
        $skipErrors = $request->has('skip_errors');

        // Split by separator
        $soalBlocks = preg_split('/===+/', $bulkData);
        $soalBlocks = array_filter(array_map('trim', $soalBlocks));

        $successCount = 0;
        $errorCount = 0;
        $errors = [];
        $skippedCount = 0;

        foreach ($soalBlocks as $index => $block) {
            $soalNumber = $index + 1;
            
            try {
                // Check if ujian is full
                if ($ujian->jumlah_soal <= $ujian->soal->count()) {
                    $errors[] = "Soal #{$soalNumber}: Kuota soal ujian sudah penuh.";
                    $skippedCount++;
                    if (!$skipErrors) break;
                    continue;
                }

                // Parse the block
                $parsed = $this->parseSoalBlock($block, $ujian->jenis_ujian);
                
                // Additional validation for SKD
                if ($ujian->jenis_ujian == 'skd') {
                    $jenisSoal = $parsed['jenis_soal'];
                    $currentCount = $ujian->soal->where('jenis_soal', $jenisSoal)->count();
                    
                    $limits = ['twk' => 30, 'tiu' => 35, 'tkp' => 45];
                    if (isset($limits[$jenisSoal]) && $currentCount >= $limits[$jenisSoal]) {
                        $errors[] = "Soal #{$soalNumber}: Kuota soal " . strtoupper($jenisSoal) . " sudah penuh ({$limits[$jenisSoal]} soal).";
                        $skippedCount++;
                        if (!$skipErrors) break;
                        continue;
                    }
                }

                // Create soal
                $soal = new Soal();
                $soal->ujian_id = $id;
                $soal->soal = $parsed['soal'];
                $soal->jenis_soal = $parsed['jenis_soal'];
                $soal->pembahasan = $parsed['pembahasan'];
                
                // Set poin
                if ($parsed['jenis_soal'] != 'tkp') {
                    $soal->poin_benar = $parsed['nilai_benar'];
                    $soal->poin_salah = $parsed['nilai_salah'];
                    $soal->poin_kosong = $parsed['nilai_kosong'];
                } else {
                    $soal->poin_benar = 0;
                    $soal->poin_salah = 0;
                    $soal->poin_kosong = 0;
                }
                
                $soal->save();

                // Create jawaban
                $jawabanIds = [];
                foreach ($parsed['jawaban'] as $key => $jawabanText) {
                    $jawaban = new Jawaban();
                    $jawaban->soal_id = $soal->id;
                    $jawaban->jawaban = $jawabanText;
                    $jawaban->point = $parsed['points'][$key] ?? 0;
                    $jawaban->save();
                    $jawabanIds[$key] = $jawaban->id;
                }

                // Set kunci jawaban for non-TKP
                if ($parsed['jenis_soal'] != 'tkp' && isset($parsed['kunci'])) {
                    $kunciIndex = ord(strtoupper($parsed['kunci'])) - 65; // A=0, B=1, etc
                    if (isset($jawabanIds[$kunciIndex])) {
                        $soal->kunci_jawaban = $jawabanIds[$kunciIndex];
                        $soal->save();
                    }
                }

                // Reload ujian to update count
                $ujian->load('soal');
                $successCount++;

            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "Soal #{$soalNumber}: " . $e->getMessage();
                
                if (!$skipErrors) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Import gagal pada soal #' . $soalNumber . ': ' . $e->getMessage());
                }
            }
        }

        // Generate result message
        $message = "Import selesai. Berhasil: {$successCount} soal";
        if ($errorCount > 0) {
            $message .= ", Gagal: {$errorCount} soal";
        }
        if ($skippedCount > 0) {
            $message .= ", Dilewati: {$skippedCount} soal";
        }

        if ($successCount > 0) {
            $session = ['success' => $message];
            if (!empty($errors)) {
                $session['warning'] = 'Beberapa soal gagal diimport: ' . implode(' | ', array_slice($errors, 0, 5));
            }
            return redirect()->route('admin.ujian.soal.index', $id)->with($session);
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tidak ada soal yang berhasil diimport. ' . implode(' | ', $errors));
        }
    }

    /**
     * Parse single soal block
     */
    private function parseSoalBlock($block, $jenisUjian)
    {
        $lines = explode("\n", $block);
        $lines = array_map('trim', $lines);
        $lines = array_filter($lines); // Remove empty lines

        $result = [
            'jenis_soal' => null,
            'soal' => '',
            'jawaban' => [],
            'kunci' => null,
            'points' => [0, 0, 0, 0, 0],
            'nilai_benar' => 5,
            'nilai_salah' => 0,
            'nilai_kosong' => 0,
            'pembahasan' => '',
        ];

        $currentSection = null;
        $soalLines = [];
        $pembahasanLines = [];

        foreach ($lines as $line) {
            // Parse field markers
            if (preg_match('/^JENIS_SOAL:\s*(.+)$/i', $line, $matches)) {
                $result['jenis_soal'] = strtolower(trim($matches[1]));
                continue;
            }
            if (preg_match('/^SOAL:\s*(.*)$/i', $line, $matches)) {
                $currentSection = 'soal';
                $soalLines[] = trim($matches[1]);
                continue;
            }
            if (preg_match('/^KUNCI:\s*([A-E])$/i', $line, $matches)) {
                $result['kunci'] = strtoupper(trim($matches[1]));
                $currentSection = null;
                continue;
            }
            if (preg_match('/^POINT_([A-E]):\s*(\d+)$/i', $line, $matches)) {
                $index = ord(strtoupper($matches[1])) - 65;
                $result['points'][$index] = (int)$matches[2];
                continue;
            }
            if (preg_match('/^NILAI_BENAR:\s*(-?\d+)$/i', $line, $matches)) {
                $result['nilai_benar'] = (int)$matches[1];
                continue;
            }
            if (preg_match('/^NILAI_SALAH:\s*(-?\d+)$/i', $line, $matches)) {
                $result['nilai_salah'] = (int)$matches[1];
                continue;
            }
            if (preg_match('/^NILAI_KOSONG:\s*(-?\d+)$/i', $line, $matches)) {
                $result['nilai_kosong'] = (int)$matches[1];
                continue;
            }
            if (preg_match('/^PEMBAHASAN:\s*(.*)$/i', $line, $matches)) {
                $currentSection = 'pembahasan';
                $pembahasanLines[] = trim($matches[1]);
                continue;
            }
            
            // Parse jawaban
            if (preg_match('/^([A-E])\.\s*(.+)$/i', $line, $matches)) {
                $index = ord(strtoupper($matches[1])) - 65;
                $result['jawaban'][$index] = trim($matches[2]);
                $currentSection = null;
                continue;
            }

            // Continue multi-line content
            if ($currentSection == 'soal') {
                $soalLines[] = $line;
            } elseif ($currentSection == 'pembahasan') {
                $pembahasanLines[] = $line;
            }
        }

        $result['soal'] = implode("\n", $soalLines);
        $result['pembahasan'] = implode("\n", $pembahasanLines);

        // Validation
        if (empty($result['soal'])) {
            throw new \Exception('Soal tidak boleh kosong');
        }

        if (count($result['jawaban']) < 5) {
            throw new \Exception('Harus ada 5 pilihan jawaban (A-E)');
        }

        // Validate jenis_soal for SKD
        if ($jenisUjian == 'skd') {
            if (empty($result['jenis_soal'])) {
                throw new \Exception('JENIS_SOAL wajib diisi untuk ujian SKD (TWK/TIU/TKP)');
            }
            if (!in_array($result['jenis_soal'], ['twk', 'tiu', 'tkp'])) {
                throw new \Exception('JENIS_SOAL harus TWK, TIU, atau TKP');
            }

            // Validate TKP points
            if ($result['jenis_soal'] == 'tkp') {
                foreach ($result['points'] as $point) {
                    if ($point <= 0) {
                        throw new \Exception('Untuk soal TKP, semua POINT_A sampai POINT_E harus diisi dengan nilai > 0');
                    }
                }
            } else {
                // Validate kunci for non-TKP
                if (empty($result['kunci'])) {
                    throw new \Exception('KUNCI jawaban wajib diisi untuk soal TWK/TIU');
                }
            }
        } else {
            // Non-SKD must have kunci
            if (empty($result['kunci'])) {
                throw new \Exception('KUNCI jawaban wajib diisi');
            }
        }

        return $result;
    }
}
