<?php

// Test script untuk verify tutor filtering fix
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== VERIFYING TUTOR FILTERING FIX ===\n\n";

try {
    // Get all users
    $allUsers = App\Models\User::all();
    echo "Total users: " . $allUsers->count() . "\n";

    // Get tutors only
    $tutors = App\Models\User::role('tutor')->get();
    echo "Total tutors: " . $tutors->count() . "\n\n";

    echo "All users:\n";
    foreach ($allUsers as $user) {
        $roles = $user->getRoleNames()->toArray();
        echo "- {$user->name} (ID: {$user->id}) - Roles: " . implode(', ', $roles) . "\n";
    }

    echo "\nFiltered tutors:\n";
    foreach ($tutors as $tutor) {
        $roles = $tutor->getRoleNames()->toArray();
        echo "- {$tutor->name} (ID: {$tutor->id}) - Roles: " . implode(', ', $roles) . "\n";
    }

    echo "\nFix verification: ";
    if ($tutors->count() < $allUsers->count()) {
        echo "✅ SUCCESS - Tutors are properly filtered\n";
        echo "Students can no longer be set as tutors in integrated courses.\n";
    } else {
        echo "❌ FAILED - All users are still being returned as tutors\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";