<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Testimonial;

echo "=== MENAMBAHKAN SAMPLE TESTIMONIALS ===\n\n";

// Check current testimonials
$currentCount = Testimonial::count();
echo "Testimonials saat ini: {$currentCount}\n\n";

// Add sample testimonials
$sampleData = [
    [
        'name' => 'Ahmad Rahman',
        'graduation' => 'Universitas Indonesia',
        'message' => 'Platform ini sangat membantu saya dalam mempersiapkan ujian kedinasan. Materi yang disediakan sangat lengkap dan mudah dipahami. Terima kasih DinasSolution!',
        'rating' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Siti Nurhaliza',
        'graduation' => 'SMA Negeri 1 Jakarta',
        'message' => 'Tutor-tutornya sangat kompeten dan selalu siap membantu. Pembelajarannya sangat menarik dan membuat saya termotivasi untuk belajar lebih giat.',
        'rating' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Budi Santoso',
        'graduation' => 'Institut Teknologi Bandung',
        'message' => 'Sistem tryout online sangat user-friendly dan mirip dengan ujian sebenarnya. Saya merasa lebih siap menghadapi SPMB berkat DinasSolution.',
        'rating' => 4,
        'is_active' => true,
    ],
    [
        'name' => 'Maya Sari',
        'graduation' => 'Universitas Gadjah Mada',
        'message' => 'Materi pembelajaran yang disusun dengan baik membuat belajar menjadi lebih efektif. Dukungan dari tim sangat membantu perjalanan belajar saya.',
        'rating' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Rizki Pratama',
        'graduation' => 'SMA Negeri 3 Surabaya',
        'message' => 'Customer service yang responsif dan materi berkualitas tinggi. Recommended untuk semua yang ingin persiapan kedinasan yang serius.',
        'rating' => 4,
        'is_active' => true,
    ],
    [
        'name' => 'Anisa Putri',
        'graduation' => 'Universitas Airlangga',
        'message' => 'Try out rutin membantu saya melatih kemampuan dan mengatur waktu dengan baik. Sistem ranking juga memotivasi untuk terus belajar.',
        'rating' => 5,
        'is_active' => true,
    ],
];

$addedCount = 0;
foreach ($sampleData as $data) {
    Testimonial::create($data);
    echo "✅ Ditambahkan: {$data['name']} ({$data['graduation']})\n";
    $addedCount++;
}

echo "\n=== HASIL AKHIR ===\n";
echo "Total testimonials: " . Testimonial::count() . "\n";
echo "Testimonials aktif: " . Testimonial::where('is_active', true)->count() . "\n";
echo "Testimonials ditambahkan: {$addedCount}\n";

echo "\n🎉 Sample testimonials berhasil ditambahkan!\n";
echo "\n📋 Cara test:\n";
echo "1. Buka http://localhost:8000 di browser\n";
echo "2. Scroll ke bagian Testimoni\n";
echo "3. Anda akan melihat testimonials yang ditampilkan secara dinamis\n";
echo "4. Login ke admin dashboard untuk mengelola testimonials\n";
echo "5. Pergi ke menu Testimonial untuk edit/hapus/tambah\n";