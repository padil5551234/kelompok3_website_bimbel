<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}