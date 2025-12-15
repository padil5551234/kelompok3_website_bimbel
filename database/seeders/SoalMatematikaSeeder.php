<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\Jawaban;

class SoalMatematikaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat ujian matematika dulu (jika belum ada)
        $ujian = Ujian::firstOrCreate([
            'nama' => 'Tryout Matematika Dasar'
        ], [
            'jenis_ujian' => 'umum', // bukan SKD
            'lama_pengerjaan' => 90,
            'waktu_mulai' => now()->addDays(1),
            'waktu_akhir' => now()->addDays(7),
            'isPublished' => 0,
            'jumlah_soal' => 10 // sesuaikan dengan jumlah soal yang dibuat
        ]);

        // Update kolom tambahan jika ada
        $ujian->update([
            'deskripsi' => 'Ujian tryout untuk menguji kemampuan matematika dasar',
            'peraturan' => '<p>1. Waktu pengerjaan 90 menit</p><p>2. Total soal 10 soal</p><p>3. Dilarang menggunakan kalkulator</p>',
            'tipe_ujian' => 1,
            'tampil_kunci' => 1,
            'tampil_nilai' => 1,
            'tampil_poin' => 1,
            'random' => 0,
        ]);

        // Array soal matematika dengan jawaban
        $soalMatematika = [
            [
                'soal' => '<p><strong>Soal 1:</strong> Hasil dari 15 × 12 - 80 ÷ 4 adalah...</p>',
                'jawaban' => [
                    '160',
                    '180',
                    '200',
                    '220',
                    '240'
                ],
                'kunci_jawaban' => 0, // jawaban A (160)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>15 × 12 - 80 ÷ 4<br>= 180 - 20<br>= 160</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 2:</strong> Jika x + 5 = 12, maka nilai x adalah...</p>',
                'jawaban' => [
                    '5',
                    '6',
                    '7',
                    '8',
                    '9'
                ],
                'kunci_jawaban' => 2, // jawaban C (7)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>x + 5 = 12<br>x = 12 - 5<br>x = 7</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 3:</strong> Luas persegi dengan sisi 8 cm adalah...</p>',
                'jawaban' => [
                    '32 cm²',
                    '48 cm²',
                    '56 cm²',
                    '64 cm²',
                    '72 cm²'
                ],
                'kunci_jawaban' => 3, // jawaban D (64 cm²)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>Luas persegi = sisi × sisi<br>= 8 × 8<br>= 64 cm²</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 4:</strong> Hasil dari √144 + √81 adalah...</p>',
                'jawaban' => [
                    '19',
                    '20',
                    '21',
                    '22',
                    '23'
                ],
                'kunci_jawaban' => 2, // jawaban C (21)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>√144 + √81<br>= 12 + 9<br>= 21</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 5:</strong> Jika 3x - 6 = 15, maka nilai 2x adalah...</p>',
                'jawaban' => [
                    '12',
                    '14',
                    '16',
                    '18',
                    '20'
                ],
                'kunci_jawaban' => 1, // jawaban B (14)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>3x - 6 = 15<br>3x = 15 + 6<br>3x = 21<br>x = 7<br>Jadi 2x = 2 × 7 = 14</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 6:</strong> Volume kubus dengan rusuk 5 cm adalah...</p>',
                'jawaban' => [
                    '100 cm³',
                    '125 cm³',
                    '150 cm³',
                    '175 cm³',
                    '200 cm³'
                ],
                'kunci_jawaban' => 1, // jawaban B (125 cm³)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>Volume kubus = rusuk³<br>= 5³<br>= 5 × 5 × 5<br>= 125 cm³</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 7:</strong> Hasil dari (2 + 3)² - (4 - 1)² adalah...</p>',
                'jawaban' => [
                    '14',
                    '15',
                    '16',
                    '17',
                    '18'
                ],
                'kunci_jawaban' => 2, // jawaban C (16)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>(2 + 3)² - (4 - 1)²<br>= 5² - 3²<br>= 25 - 9<br>= 16</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 8:</strong> Jika a = 4 dan b = 6, maka nilai dari a² + b² adalah...</p>',
                'jawaban' => [
                    '48',
                    '50',
                    '52',
                    '54',
                    '56'
                ],
                'kunci_jawaban' => 2, // jawaban C (52)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>a² + b² dengan a = 4 dan b = 6<br>= 4² + 6²<br>= 16 + 36<br>= 52</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 9:</strong> Keliling persegi panjang dengan panjang 12 cm dan lebar 8 cm adalah...</p>',
                'jawaban' => [
                    '36 cm',
                    '38 cm',
                    '40 cm',
                    '42 cm',
                    '44 cm'
                ],
                'kunci_jawaban' => 2, // jawaban C (40 cm)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>Keliling persegi panjang = 2 × (panjang + lebar)<br>= 2 × (12 + 8)<br>= 2 × 20<br>= 40 cm</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ],
            [
                'soal' => '<p><strong>Soal 10:</strong> Hasil dari 7! ÷ 5! adalah...</p>',
                'jawaban' => [
                    '40',
                    '42',
                    '44',
                    '46',
                    '48'
                ],
                'kunci_jawaban' => 1, // jawaban B (42)
                'pembahasan' => '<p><strong>Pembahasan:</strong><br>7! ÷ 5! = (7 × 6 × 5!) ÷ 5!<br>= 7 × 6<br>= 42</p>',
                'poin_benar' => 4,
                'poin_salah' => -1,
                'poin_kosong' => 0
            ]
        ];

        // Simpan soal dan jawaban ke database
        foreach ($soalMatematika as $index => $dataSoal) {
            $soal = new Soal();
            $soal->ujian_id = $ujian->id;
            $soal->soal = $dataSoal['soal'];
            $soal->jenis_soal = null; // karena bukan ujian SKD
            $soal->poin_benar = $dataSoal['poin_benar'];
            $soal->poin_salah = $dataSoal['poin_salah'];
            $soal->poin_kosong = $dataSoal['poin_kosong'];
            $soal->pembahasan = $dataSoal['pembahasan'];
            $soal->save();

            // Simpan jawaban
            foreach ($dataSoal['jawaban'] as $key => $jawabanText) {
                $jawaban = new Jawaban();
                $jawaban->soal_id = $soal->id;
                $jawaban->jawaban = $jawabanText;
                $jawaban->point = 0; // untuk soal non-TKP, point jawaban = 0
                $jawaban->save();

                // Set kunci jawaban
                if ($key == $dataSoal['kunci_jawaban']) {
                    $soal->kunci_jawaban = $jawaban->id;
                    $soal->save();
                }
            }
        }

        echo "✅ Berhasil menambahkan 10 soal matematika ke ujian: " . $ujian->nama . "\n";
    }
}