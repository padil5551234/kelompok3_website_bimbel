<?php

namespace Database\Seeders;

use App\Models\Formasi;
use Illuminate\Database\Seeder;

class FormasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formasis = [
            [
                'kode' => '00',
                'nama' => 'Umum/Lainnya'
            ],
            [
                'kode' => '01',
                'nama' => 'Badan Pusat Statistik Pusat'
            ],
            [
                'kode' => '02', 
                'nama' => 'BPS Provinsi Aceh'
            ],
            [
                'kode' => '03',
                'nama' => 'BPS Provinsi Sumatera Utara'
            ],
            [
                'kode' => '04',
                'nama' => 'BPS Provinsi Sumatera Barat'
            ],
            [
                'kode' => '05',
                'nama' => 'BPS Provinsi Riau'
            ],
            [
                'kode' => '06',
                'nama' => 'BPS Provinsi Jambi'
            ],
            [
                'kode' => '07',
                'nama' => 'BPS Provinsi Sumatera Selatan'
            ],
            [
                'kode' => '08',
                'nama' => 'BPS Provinsi Bengkulu'
            ],
            [
                'kode' => '09',
                'nama' => 'BPS Provinsi Lampung'
            ],
            [
                'kode' => '10',
                'nama' => 'BPS Provinsi Kepulauan Bangka Belitung'
            ],
            [
                'kode' => '11',
                'nama' => 'BPS Provinsi Kepulauan Riau'
            ],
            [
                'kode' => '12',
                'nama' => 'BPS Provinsi DKI Jakarta'
            ],
            [
                'kode' => '13',
                'nama' => 'BPS Provinsi Jawa Barat'
            ],
            [
                'kode' => '14',
                'nama' => 'BPS Provinsi Jawa Tengah'
            ],
            [
                'kode' => '15',
                'nama' => 'BPS Provinsi DI Yogyakarta'
            ],
            [
                'kode' => '16',
                'nama' => 'BPS Provinsi Jawa Timur'
            ],
            [
                'kode' => '17',
                'nama' => 'BPS Provinsi Banten'
            ],
            [
                'kode' => '18',
                'nama' => 'BPS Provinsi Bali'
            ],
            [
                'kode' => '19',
                'nama' => 'BPS Provinsi Nusa Tenggara Barat'
            ],
            [
                'kode' => '20',
                'nama' => 'BPS Provinsi Nusa Tenggara Timur'
            ],
            [
                'kode' => '21',
                'nama' => 'BPS Provinsi Kalimantan Barat'
            ],
            [
                'kode' => '22',
                'nama' => 'BPS Provinsi Kalimantan Tengah'
            ],
            [
                'kode' => '23',
                'nama' => 'BPS Provinsi Kalimantan Selatan'
            ],
            [
                'kode' => '24',
                'nama' => 'BPS Provinsi Kalimantan Timur'
            ],
            [
                'kode' => '25',
                'nama' => 'BPS Provinsi Kalimantan Utara'
            ],
            [
                'kode' => '26',
                'nama' => 'BPS Provinsi Sulawesi Utara'
            ],
            [
                'kode' => '27',
                'nama' => 'BPS Provinsi Sulawesi Tengah'
            ],
            [
                'kode' => '28',
                'nama' => 'BPS Provinsi Sulawesi Selatan'
            ],
            [
                'kode' => '29',
                'nama' => 'BPS Provinsi Sulawesi Tenggara'
            ],
            [
                'kode' => '30',
                'nama' => 'BPS Provinsi Gorontalo'
            ],
            [
                'kode' => '31',
                'nama' => 'BPS Provinsi Sulawesi Barat'
            ],
            [
                'kode' => '32',
                'nama' => 'BPS Provinsi Maluku'
            ],
            [
                'kode' => '33',
                'nama' => 'BPS Provinsi Maluku Utara'
            ],
            [
                'kode' => '34',
                'nama' => 'BPS Provinsi Papua Barat'
            ],
            [
                'kode' => '35',
                'nama' => 'BPS Provinsi Papua'
            ],
            [
                'kode' => '36',
                'nama' => 'BPS Provinsi Papua Tengah'
            ],
            [
                'kode' => '37',
                'nama' => 'BPS Provinsi Papua Pegunungan'
            ],
            [
                'kode' => '38',
                'nama' => 'BPS Provinsi Papua Selatan'
            ],
            [
                'kode' => '39',
                'nama' => 'BPS Provinsi Papua Barat Daya'
            ]
        ];

        foreach ($formasis as $formasi) {
            Formasi::updateOrCreate(
                ['kode' => $formasi['kode']],
                ['nama' => $formasi['nama']]
            );
        }
    }
}