<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Testimonial;

echo "=== CHECKING TESTIMONIALS IN DATABASE ===\n\n";

$testimonials = Testimonial::all();

echo "Total testimonials: " . $testimonials->count() . "\n\n";

if ($testimonials->isEmpty()) {
    echo "❌ No testimonials found in database!\n";
    echo "Run: php add_sample_testimonials.php\n";
} else {
    echo "✅ Testimonials found:\n\n";
    foreach ($testimonials as $testimonial) {
        echo "ID: {$testimonial->id}\n";
        echo "Name: {$testimonial->name}\n";
        echo "Graduation: " . ($testimonial->graduation ?? 'Not set') . "\n";
        echo "Rating: {$testimonial->rating}\n";
        echo "Active: " . ($testimonial->is_active ? 'Yes' : 'No') . "\n";
        echo "Message: " . substr($testimonial->message, 0, 50) . "...\n";
        echo "Created: {$testimonial->created_at}\n";
        echo "------------------------\n";
    }
}

echo "\n=== CHECKING ACTIVE TESTIMONIALS ===\n";
$activeTestimonials = Testimonial::where('is_active', true)->get();
echo "Active testimonials: " . $activeTestimonials->count() . "\n";

if ($activeTestimonials->isEmpty()) {
    echo "❌ No active testimonials - they won't show on dashboard!\n";
    echo "Make sure testimonials have is_active = true\n";
} else {
    echo "✅ Active testimonials will show on dashboard\n";
}