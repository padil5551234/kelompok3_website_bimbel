<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\PaketUjian;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaketUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seed = [
            [
                'id' => '33370256-b734-470a-afe9-c7ca8421f1b3',
                'nama' => 'TOBAR Batch 1',
                'harga' => 100000,
                'waktu_mulai' => Carbon::parse('2025-11-01 00:00:00'),
                'waktu_akhir' => Carbon::parse('2025-12-31 23:59:59'),
            ],
            [
                'id' => '981ae5b5-a48d-47e6-9cc7-9e79994a3ef0',
                'nama' => 'TOBAR Batch 2',
                'harga' => 125000,
                'waktu_mulai' => Carbon::parse('2025-11-01 00:00:00'),
                'waktu_akhir' => Carbon::parse('2025-12-31 23:59:59'),
            ],
            [
                'id' => '0be570c6-7edf-4970-bd99-304d0626f9ff',
                'nama' => 'TOBAR Batch 3',
                'harga' => 150000,
                'waktu_mulai' => Carbon::parse('2025-11-01 00:00:00'),
                'waktu_akhir' => Carbon::parse('2025-12-31 23:59:59'),
            ],
            [
                'id' => '0df8c9b0-d352-448b-9611-abadffc4f46d',
                'nama' => 'BIUS',
                'harga' => 300000,
                'waktu_mulai' => Carbon::parse('2025-11-01 00:00:00'),
                'waktu_akhir' => Carbon::parse('2025-12-31 23:59:59'),
            ],
            [
                'id' => 'd5f57505-fb5a-4f59-a301-3722ef581844',
                'nama' => 'Paket Kedinasan',
                'harga' => 250000,
                'waktu_mulai' => Carbon::parse('2025-11-01 00:00:00'),
                'waktu_akhir' => Carbon::parse('2025-12-31 23:59:59'),
            ],
        ];

        foreach ($seed as $paket) {
            PaketUjian::updateOrCreate(
                ['id' => $paket['id']],
                $paket
            );
        }
    }
}
