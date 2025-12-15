<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = [
            [
                'kode' => 1,
                'nama' => 'D3 Statistika'
            ],
            [
                'kode' => 2,
                'nama' => 'D4 Statistika Terapan'
            ],
            [
                'kode' => 3,
                'nama' => 'D4 Komputasi Statistik'
            ],
            [
                'kode' => 4,
                'nama' => 'Lainnya'
            ]
        ];

        foreach ($prodis as $prodi) {
            Prodi::updateOrCreate(
                ['kode' => $prodi['kode']],
                ['nama' => $prodi['nama']]
            );
        }
    }
}