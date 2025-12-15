<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wilayah = [
            // Provinsi
            ['kode' => '11', 'nama' => 'Aceh'],
            ['kode' => '12', 'nama' => 'Sumatera Utara'],
            ['kode' => '13', 'nama' => 'Sumatera Barat'],
            ['kode' => '14', 'nama' => 'Riau'],
            ['kode' => '15', 'nama' => 'Jambi'],
            ['kode' => '16', 'nama' => 'Sumatera Selatan'],
            ['kode' => '17', 'nama' => 'Bengkulu'],
            ['kode' => '18', 'nama' => 'Lampung'],
            ['kode' => '19', 'nama' => 'Kepulauan Bangka Belitung'],
            ['kode' => '21', 'nama' => 'Kepulauan Riau'],
            ['kode' => '31', 'nama' => 'DKI Jakarta'],
            ['kode' => '32', 'nama' => 'Jawa Barat'],
            ['kode' => '33', 'nama' => 'Jawa Tengah'],
            ['kode' => '34', 'nama' => 'DI Yogyakarta'],
            ['kode' => '35', 'nama' => 'Jawa Timur'],
            ['kode' => '36', 'nama' => 'Banten'],
            ['kode' => '51', 'nama' => 'Bali'],
            ['kode' => '52', 'nama' => 'Nusa Tenggara Barat'],
            ['kode' => '53', 'nama' => 'Nusa Tenggara Timur'],
            ['kode' => '61', 'nama' => 'Kalimantan Barat'],
            ['kode' => '62', 'nama' => 'Kalimantan Tengah'],
            ['kode' => '63', 'nama' => 'Kalimantan Selatan'],
            ['kode' => '64', 'nama' => 'Kalimantan Timur'],
            ['kode' => '65', 'nama' => 'Kalimantan Utara'],
            ['kode' => '71', 'nama' => 'Sulawesi Utara'],
            ['kode' => '72', 'nama' => 'Sulawesi Tengah'],
            ['kode' => '73', 'nama' => 'Sulawesi Selatan'],
            ['kode' => '74', 'nama' => 'Sulawesi Tenggara'],
            ['kode' => '75', 'nama' => 'Gorontalo'],
            ['kode' => '76', 'nama' => 'Sulawesi Barat'],
            ['kode' => '81', 'nama' => 'Maluku'],
            ['kode' => '82', 'nama' => 'Maluku Utara'],
            ['kode' => '91', 'nama' => 'Papua Barat'],
            ['kode' => '92', 'nama' => 'Papua'],
            ['kode' => '93', 'nama' => 'Papua Tengah'],
            ['kode' => '94', 'nama' => 'Papua Pegunungan'],
            ['kode' => '95', 'nama' => 'Papua Selatan'],
            ['kode' => '96', 'nama' => 'Papua Barat Daya'],
            
            // Kabupaten/Kota DKI Jakarta
            ['kode' => '31.01', 'nama' => 'Kepulauan Seribu'],
            ['kode' => '31.71', 'nama' => 'Jakarta Selatan'],
            ['kode' => '31.72', 'nama' => 'Jakarta Timur'],
            ['kode' => '31.73', 'nama' => 'Jakarta Pusat'],
            ['kode' => '31.74', 'nama' => 'Jakarta Barat'],
            ['kode' => '31.75', 'nama' => 'Jakarta Utara'],
            
            // Kabupaten/Kota Jawa Barat (sample)
            ['kode' => '32.01', 'nama' => 'Bogor'],
            ['kode' => '32.02', 'nama' => 'Sukabumi'],
            ['kode' => '32.03', 'nama' => 'Cianjur'],
            ['kode' => '32.04', 'nama' => 'Bandung'],
            ['kode' => '32.71', 'nama' => 'Kota Bogor'],
            ['kode' => '32.72', 'nama' => 'Kota Sukabumi'],
            ['kode' => '32.73', 'nama' => 'Kota Bandung'],
            ['kode' => '32.74', 'nama' => 'Kota Cirebon'],
            ['kode' => '32.75', 'nama' => 'Kota Bekasi'],
            ['kode' => '32.76', 'nama' => 'Kota Depok'],
            ['kode' => '32.77', 'nama' => 'Kota Cimahi'],
            
            // Kecamatan Jakarta Selatan (sample)
            ['kode' => '31.71.01', 'nama' => 'Jagakarsa'],
            ['kode' => '31.71.02', 'nama' => 'Pasar Minggu'],
            ['kode' => '31.71.03', 'nama' => 'Cilandak'],
            ['kode' => '31.71.04', 'nama' => 'Pesanggrahan'],
            ['kode' => '31.71.05', 'nama' => 'Kebayoran Lama'],
            ['kode' => '31.71.06', 'nama' => 'Kebayoran Baru'],
            ['kode' => '31.71.07', 'nama' => 'Mampang Prapatan'],
            ['kode' => '31.71.08', 'nama' => 'Pancoran'],
            ['kode' => '31.71.09', 'nama' => 'Tebet'],
            ['kode' => '31.71.10', 'nama' => 'Setiabudi'],
            
            // Kecamatan Kota Bogor (sample)
            ['kode' => '32.71.01', 'nama' => 'Bogor Selatan'],
            ['kode' => '32.71.02', 'nama' => 'Bogor Timur'],
            ['kode' => '32.71.03', 'nama' => 'Bogor Utara'],
            ['kode' => '32.71.04', 'nama' => 'Bogor Tengah'],
            ['kode' => '32.71.05', 'nama' => 'Bogor Barat'],
            ['kode' => '32.71.06', 'nama' => 'Tanah Sareal'],
            
            // Kecamatan Kota Bandung (sample)
            ['kode' => '32.73.01', 'nama' => 'Bandung Kulon'],
            ['kode' => '32.73.02', 'nama' => 'Babakan Ciparay'],
            ['kode' => '32.73.03', 'nama' => 'Bojongloa Kaler'],
            ['kode' => '32.73.04', 'nama' => 'Bojongloa Kidul'],
            ['kode' => '32.73.05', 'nama' => 'Astana Anyar'],
            ['kode' => '32.73.06', 'nama' => 'Regol'],
            ['kode' => '32.73.07', 'nama' => 'Lengkong'],
            ['kode' => '32.73.08', 'nama' => 'Bandung Kidul'],
            ['kode' => '32.73.09', 'nama' => 'Buahbatu'],
            ['kode' => '32.73.10', 'nama' => 'Rancasari'],
        ];

        foreach ($wilayah as $data) {
            Wilayah::updateOrCreate(
                ['kode' => $data['kode']],
                ['nama' => $data['nama']]
            );
        }
    }
}