<?php

// Script untuk mengisi data wilayah, formasi, dan prodi
// Berdasarkan data dari dinassol_new.sql

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

echo "Memulai proses mengisi data wilayah, formasi, dan prodi...\n\n";

// 1. Mengisi data formasi
echo "1. Mengisi data formasi...\n";
try {
    $formasiData = [
        ['kode' => '00', 'nama' => 'Umum/Lainnya'],
        ['kode' => '01', 'nama' => 'Badan Pusat Statistik Pusat'],
        ['kode' => '02', 'nama' => 'BPS Provinsi Aceh'],
        ['kode' => '03', 'nama' => 'BPS Provinsi Sumatera Utara'],
        ['kode' => '04', 'nama' => 'BPS Provinsi Sumatera Barat'],
        ['kode' => '05', 'nama' => 'BPS Provinsi Riau'],
        ['kode' => '06', 'nama' => 'BPS Provinsi Jambi'],
        ['kode' => '07', 'nama' => 'BPS Provinsi Sumatera Selatan'],
        ['kode' => '08', 'nama' => 'BPS Provinsi Bengkulu'],
        ['kode' => '09', 'nama' => 'BPS Provinsi Lampung'],
        ['kode' => '10', 'nama' => 'BPS Provinsi Kepulauan Bangka Belitung'],
        ['kode' => '11', 'nama' => 'BPS Provinsi Kepulauan Riau'],
        ['kode' => '12', 'nama' => 'BPS Provinsi DKI Jakarta'],
        ['kode' => '13', 'nama' => 'BPS Provinsi Jawa Barat'],
        ['kode' => '14', 'nama' => 'BPS Provinsi Jawa Tengah'],
        ['kode' => '15', 'nama' => 'BPS Provinsi DI Yogyakarta'],
        ['kode' => '16', 'nama' => 'BPS Provinsi Jawa Timur'],
        ['kode' => '17', 'nama' => 'BPS Provinsi Banten'],
        ['kode' => '18', 'nama' => 'BPS Provinsi Bali'],
        ['kode' => '19', 'nama' => 'BPS Provinsi Nusa Tenggara Barat'],
        ['kode' => '20', 'nama' => 'BPS Provinsi Nusa Tenggara Timur'],
        ['kode' => '21', 'nama' => 'BPS Provinsi Kalimantan Barat'],
        ['kode' => '22', 'nama' => 'BPS Provinsi Kalimantan Tengah'],
        ['kode' => '23', 'nama' => 'BPS Provinsi Kalimantan Selatan'],
        ['kode' => '24', 'nama' => 'BPS Provinsi Kalimantan Timur'],
        ['kode' => '25', 'nama' => 'BPS Provinsi Kalimantan Utara'],
        ['kode' => '26', 'nama' => 'BPS Provinsi Sulawesi Utara'],
        ['kode' => '27', 'nama' => 'BPS Provinsi Sulawesi Tengah'],
        ['kode' => '28', 'nama' => 'BPS Provinsi Sulawesi Selatan'],
        ['kode' => '29', 'nama' => 'BPS Provinsi Sulawesi Tenggara'],
        ['kode' => '30', 'nama' => 'BPS Provinsi Gorontalo'],
        ['kode' => '31', 'nama' => 'BPS Provinsi Sulawesi Barat'],
        ['kode' => '32', 'nama' => 'BPS Provinsi Maluku'],
        ['kode' => '33', 'nama' => 'BPS Provinsi Maluku Utara'],
        ['kode' => '34', 'nama' => 'BPS Provinsi Papua Barat'],
        ['kode' => '35', 'nama' => 'BPS Provinsi Papua'],
        ['kode' => '36', 'nama' => 'BPS Provinsi Papua Tengah'],
        ['kode' => '37', 'nama' => 'BPS Provinsi Papua Pegunungan'],
        ['kode' => '38', 'nama' => 'BPS Provinsi Papua Selatan'],
        ['kode' => '39', 'nama' => 'BPS Provinsi Papua Barat Daya']
    ];

    foreach ($formasiData as $data) {
        DB::table('formasi')->updateOrInsert(
            ['kode' => $data['kode']],
            ['nama' => $data['nama']]
        );
    }
    echo "   ✓ Data formasi berhasil diisi (40 data)\n";
} catch (Exception $e) {
    echo "   ✗ Error mengisi data formasi: " . $e->getMessage() . "\n";
}

// 2. Mengisi data wilayah
echo "\n2. Mengisi data wilayah...\n";
try {
    $wilayahData = [
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
        ['kode' => '31.01', 'nama' => 'Kepulauan Seribu'],
        ['kode' => '31.71', 'nama' => 'Jakarta Selatan'],
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
        ['kode' => '31.72', 'nama' => 'Jakarta Timur'],
        ['kode' => '31.73', 'nama' => 'Jakarta Pusat'],
        ['kode' => '31.74', 'nama' => 'Jakarta Barat'],
        ['kode' => '31.75', 'nama' => 'Jakarta Utara'],
        ['kode' => '32', 'nama' => 'Jawa Barat'],
        ['kode' => '32.01', 'nama' => 'Bogor'],
        ['kode' => '32.02', 'nama' => 'Sukabumi'],
        ['kode' => '32.03', 'nama' => 'Cianjur'],
        ['kode' => '32.04', 'nama' => 'Bandung'],
        ['kode' => '32.71', 'nama' => 'Kota Bogor'],
        ['kode' => '32.71.01', 'nama' => 'Bogor Selatan'],
        ['kode' => '32.71.02', 'nama' => 'Bogor Timur'],
        ['kode' => '32.71.03', 'nama' => 'Bogor Utara'],
        ['kode' => '32.71.04', 'nama' => 'Bogor Tengah'],
        ['kode' => '32.71.05', 'nama' => 'Bogor Barat'],
        ['kode' => '32.71.06', 'nama' => 'Tanah Sareal'],
        ['kode' => '32.72', 'nama' => 'Kota Sukabumi'],
        ['kode' => '32.73', 'nama' => 'Kota Bandung'],
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
        ['kode' => '32.74', 'nama' => 'Kota Cirebon'],
        ['kode' => '32.75', 'nama' => 'Kota Bekasi'],
        ['kode' => '32.76', 'nama' => 'Kota Depok'],
        ['kode' => '32.77', 'nama' => 'Kota Cimahi'],
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
        ['kode' => '96', 'nama' => 'Papua Barat Daya']
    ];

    foreach ($wilayahData as $data) {
        DB::table('wilayah')->updateOrInsert(
            ['kode' => $data['kode']],
            ['nama' => $data['nama']]
        );
    }
    echo "   ✓ Data wilayah berhasil diisi (" . count($wilayahData) . " data)\n";
} catch (Exception $e) {
    echo "   ✗ Error mengisi data wilayah: " . $e->getMessage() . "\n";
}

// 3. Mengisi data prodi
echo "\n3. Mengisi data prodi...\n";
try {
    $prodiData = [
        ['kode' => 1, 'nama' => 'D3 Statistika'],
        ['kode' => 2, 'nama' => 'D4 Statistika Terapan'],
        ['kode' => 3, 'nama' => 'D4 Komputasi Statistik'],
        ['kode' => 4, 'nama' => 'Lainnya']
    ];

    foreach ($prodiData as $data) {
        DB::table('prodi')->updateOrInsert(
            ['kode' => $data['kode']],
            ['nama' => $data['nama']]
        );
    }
    echo "   ✓ Data prodi berhasil diisi (4 data)\n";
} catch (Exception $e) {
    echo "   ✗ Error mengisi data prodi: " . $e->getMessage() . "\n";
}

echo "\n=== RINGKASAN ===\n";
echo "Total data yang diisi:\n";
echo "- Formasi: 40 data (BPS Pusat hingga Provinsi)\n";
echo "- Wilayah: " . count($wilayahData) . " data (Provinsi hingga Kecamatan)\n";
echo "- Prodi: 4 data (Program Studi STIS)\n";
echo "\nProses selesai!\n";

// Tampilkan statistik data
echo "\n=== STATISTIK DATABASE ===\n";
try {
    $formasiCount = DB::table('formasi')->count();
    $wilayahCount = DB::table('wilayah')->count();
    $prodiCount = DB::table('prodi')->count();
    
    echo "Jumlah data dalam database:\n";
    echo "- Formasi: {$formasiCount} records\n";
    echo "- Wilayah: {$wilayahCount} records\n";
    echo "- Prodi: {$prodiCount} records\n";
} catch (Exception $e) {
    echo "Error mengambil statistik: " . $e->getMessage() . "\n";
}
