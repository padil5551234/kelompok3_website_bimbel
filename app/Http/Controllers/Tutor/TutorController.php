<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Material;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:tutor']);
    }

    /**
     * Display the tutor dashboard.
     */
    public function dashboard()
    {
        $tutor = Auth::user();
        
        // Get statistics
        $stats = [
            'total_classes' => $tutor->liveClasses()->count(),
            'upcoming_classes' => $tutor->liveClasses()
                ->where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->count(),
            'completed_classes' => $tutor->liveClasses()
                ->where('status', 'completed')
                ->count(),
            'total_materials' => $tutor->materials()->count(),
            'public_materials' => $tutor->materials()
                ->where('is_public', true)
                ->count(),
            'total_views' => $tutor->materials()->sum('views_count') ?? 0,
        ];

        // Get recent activities
        $upcomingClasses = $tutor->liveClasses()
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->take(5)
            ->get();

        $recentMaterials = $tutor->materials()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('tutor.dashboard', compact('stats', 'upcomingClasses', 'recentMaterials'));
    }

    /**
     * Show the tutor profile form.
     */
    public function profile()
    {
        $tutor = Auth::user();
        $tutorProfile = $tutor->tutorProfile ?? new Tutor(['user_id' => $tutor->id]);

        return view('tutor.profile', compact('tutor', 'tutorProfile'));
    }

    /**
     * Update the tutor profile.
     */
    public function updateProfile(Request $request)
    {
        $tutor = Auth::user();

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
        ]);

        $tutorProfile = $tutor->tutorProfile ?? new Tutor(['user_id' => $tutor->id]);

        $tutorProfile->bio = $request->bio;
        $tutorProfile->specialization = $request->specialization;
        $tutorProfile->experience = $request->experience;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($tutorProfile->image && Storage::disk('public')->exists($tutorProfile->image)) {
                Storage::disk('public')->delete($tutorProfile->image);
            }
            $imagePath = $request->file('image')->store('tutors', 'public');
            $tutorProfile->image = $imagePath;
        }

        $tutorProfile->save();

        return redirect()->route('tutor.profile')
            ->with('success', 'Profile berhasil diperbarui');
    }
}