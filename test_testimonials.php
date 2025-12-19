<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Testimonial;

echo "=== TESTIMONIAL MANAGEMENT TEST ===\n\n";

// Check current testimonials
echo "Current testimonials in database:\n";
$testimonials = Testimonial::all();
echo "Total: " . $testimonials->count() . "\n";

if ($testimonials->isEmpty()) {
    echo "No testimonials found.\n\n";
} else {
    foreach ($testimonials as $testimonial) {
        echo "- ID: {$testimonial->id}, Name: {$testimonial->name}, Rating: {$testimonial->rating}, Active: " . ($testimonial->is_active ? 'Yes' : 'No') . "\n";
        echo "  Message: " . substr($testimonial->message, 0, 50) . "...\n\n";
    }
}

// Delete all existing testimonials
echo "Deleting all existing testimonials...\n";
Testimonial::truncate();
echo "✅ All testimonials deleted.\n\n";

// Add sample testimonials
echo "Adding sample testimonials...\n";

$sampleData = [
    [
        'name' => 'Ahmad Rahman',
        'graduation' => 'Universitas Indonesia',
        'message' => 'Platform ini sangat membantu saya dalam mempersiapkan ujian kedinasan. Materi yang disediakan sangat lengkap dan mudah dipahami.',
        'rating' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Siti Nurhaliza',
        'graduation' => 'SMA Negeri 1 Jakarta',
        'message' => 'Tutor-tutornya sangat kompeten dan selalu siap membantu. Terima kasih atas dukungannya!',
        'rating' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Budi Santoso',
        'graduation' => 'Institut Teknologi Bandung',
        'message' => 'Sistem tryout online sangat user-friendly. Saya bisa melatih kemampuan saya kapan saja.',
        'rating' => 4,
        'is_active' => true,
    ],
    [
        'name' => 'Maya Sari',
        'graduation' => 'Universitas Gadjah Mada',
        'message' => 'Materi pembelajaran yang disusun dengan baik membuat belajar menjadi lebih menarik dan efektif.',
        'rating' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Rizki Pratama',
        'graduation' => 'SMA Negeri 3 Surabaya',
        'message' => 'Dukungan customer service yang responsif membuat pengalaman belajar saya menjadi lebih baik.',
        'rating' => 4,
        'is_active' => false, // Inactive for testing
    ],
];

foreach ($sampleData as $data) {
    Testimonial::create($data);
    echo "✅ Added testimonial: {$data['name']}\n";
}

echo "\n=== FINAL STATUS ===\n";
echo "Total testimonials: " . Testimonial::count() . "\n";
echo "Active testimonials: " . Testimonial::where('is_active', true)->count() . "\n";
echo "Inactive testimonials: " . Testimonial::where('is_active', false)->count() . "\n";

echo "\n🎉 Testimonial management test completed successfully!\n";
echo "\n📋 Next Steps:\n";
echo "1. Start your Laravel development server: php artisan serve\n";
echo "2. Login to admin dashboard\n";
echo "3. Go to Testimonial menu in sidebar\n";
echo "4. You should see 5 testimonials listed\n";
echo "5. Try adding, editing, or deleting testimonials\n";
echo "6. Test the tutor profile management in the Tutor menu\n";