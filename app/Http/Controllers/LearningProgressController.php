<?php

namespace App\Http\Controllers;

use App\Models\LearningProgress;
use App\Models\StudyStatistics;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LearningProgressController extends Controller
{
    /**
     * Display learning progress dashboard
     */
    public function index()
    {
        $user = Auth::user();

        // Check if user has purchased any package
        $hasPurchasedPackage = Pembelian::where('user_id', $user->id)
            ->where('status', 'Sudah Bayar')
            ->exists();

        if (!$hasPurchasedPackage) {
            return redirect()->route('pembelian.index')
                ->with('warning', 'Anda perlu membeli paket terlebih dahulu untuk melihat tracking belajar.');
        }

        // Get overall statistics
        $totalStudyTime = LearningProgress::where('user_id', $user->id)
            ->sum('duration_seconds');

        $totalMaterialsViewed = LearningProgress::where('user_id', $user->id)
            ->where('activity_type', 'material_complete')
            ->distinct('material_id')
            ->count();

        $totalTryoutsCompleted = LearningProgress::where('user_id', $user->id)
            ->where('activity_type', 'tryout_complete')
            ->count();

        $averageScore = LearningProgress::where('user_id', $user->id)
            ->where('activity_type', 'tryout_complete')
            ->whereNotNull('score')
            ->avg('score');

        // Get recent activities
        $recentActivities = LearningProgress::where('user_id', $user->id)
            ->with(['material', 'ujian', 'paket'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get study statistics for last 30 days
        $studyStats = StudyStatistics::where('user_id', $user->id)
            ->where('study_date', '>=', now()->subDays(30))
            ->orderBy('study_date', 'asc')
            ->get();

        // Get tryout scores for chart
        $tryoutScores = LearningProgress::where('user_id', $user->id)
            ->where('activity_type', 'tryout_complete')
            ->whereNotNull('score')
            ->with('ujian')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get subject breakdown
        $subjectBreakdown = LearningProgress::where('user_id', $user->id)
            ->where('activity_type', 'tryout_complete')
            ->whereNotNull('score')
            ->select('metadata')
            ->get()
            ->pluck('metadata')
            ->filter()
            ->flatten(1)
            ->groupBy('subject')
            ->map(function ($items) {
                return [
                    'count' => $items->count(),
                    'average' => collect($items)->avg('score')
                ];
            });

        return view('progress.index', compact(
            'totalStudyTime',
            'totalMaterialsViewed',
            'totalTryoutsCompleted',
            'averageScore',
            'recentActivities',
            'studyStats',
            'tryoutScores',
            'subjectBreakdown'
        ));
    }

    /**
     * Record learning progress
     */
    public function record(Request $request)
    {
        $validated = $request->validate([
            'activity_type' => 'required|in:material_view,material_complete,tryout_attempt,tryout_complete',
            'material_id' => 'nullable|exists:materials,id',
            'ujian_id' => 'nullable|exists:ujian,id',
            'paket_id' => 'nullable|exists:paket_ujian,id',
            'duration_seconds' => 'required|integer|min:0',
            'progress_percentage' => 'nullable|integer|min:0|max:100',
            'score' => 'nullable|numeric|min:0|max:100',
            'metadata' => 'nullable|array',
        ]);

        $validated['user_id'] = Auth::id();

        if ($validated['activity_type'] === 'material_complete' || $validated['activity_type'] === 'tryout_complete') {
            $validated['completed_at'] = now();
            $validated['progress_percentage'] = 100;
        }

        $progress = LearningProgress::create($validated);

        // Update daily statistics
        $this->updateDailyStatistics($validated);

        return response()->json([
            'success' => true,
            'message' => 'Progress berhasil direkam',
            'data' => $progress
        ]);
    }

    /**
     * Update daily statistics
     */
    private function updateDailyStatistics($data)
    {
        $today = now()->toDateString();
        $userId = $data['user_id'];

        $stat = StudyStatistics::firstOrNew([
            'user_id' => $userId,
            'study_date' => $today,
        ]);

        $stat->total_study_time += $data['duration_seconds'];

        if ($data['activity_type'] === 'material_view' || $data['activity_type'] === 'material_complete') {
            $stat->materials_viewed += 1;
        }

        if ($data['activity_type'] === 'tryout_complete') {
            $stat->tryouts_completed += 1;
            
            // Update average score
            if (isset($data['score'])) {
                $allScores = LearningProgress::where('user_id', $userId)
                    ->where('activity_type', 'tryout_complete')
                    ->whereDate('created_at', $today)
                    ->whereNotNull('score')
                    ->pluck('score');
                    
                $stat->average_score = $allScores->avg();
            }
        }

        $stat->save();
    }

    /**
     * Get progress data for API
     */
    public function getProgressData(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'weekly'); // weekly, monthly, yearly

        $query = StudyStatistics::where('user_id', $user->id);

        switch ($type) {
            case 'weekly':
                $query->where('study_date', '>=', now()->subDays(7));
                break;
            case 'monthly':
                $query->where('study_date', '>=', now()->subDays(30));
                break;
            case 'yearly':
                $query->where('study_date', '>=', now()->subDays(365));
                break;
        }

        $data = $query->orderBy('study_date', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}