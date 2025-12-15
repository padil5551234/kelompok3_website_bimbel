<?php

namespace App\Http\Controllers;

use App\Models\LearningModule;
use App\Models\LearningModuleSection;
use App\Models\LearningModuleLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'profiled']);
    }

    /**
     * Display a listing of learning modules
     */
    public function index(Request $request)
    {
        $query = LearningModule::query();

        // Filter by category (SKD or MATEMATIKA_TERANTUNG)
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter by subject
        if ($request->has('subject') && $request->subject !== 'all') {
            $query->bySubject($request->subject);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty !== 'all') {
            $query->where('difficulty_level', $request->difficulty);
        }

        // Show only published modules
        $query->published();

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('subtitle', 'like', '%' . $request->search . '%');
            });
        }

        $modules = $query->with('sections')
            ->ordered()
            ->paginate(12);

        return view('views_user.learning-modules.index', compact('modules'));
    }

    /**
     * Display the specified learning module
     */
    public function show(LearningModule $learningModule)
    {
        // Check if module is published
        if (!$learningModule->is_published) {
            abort(404, 'Modul pembelajaran tidak ditemukan.');
        }

        $learningModule->load(['sections.publishedLessons']);

        return view('views_user.learning-modules.show', compact('learningModule'));
    }

    /**
     * Display a specific section within a module
     */
    public function showSection(LearningModuleSection $section)
    {
        // Check if section and its module are published
        if (!$section->is_published || !$section->learningModule->is_published) {
            abort(404, 'Section tidak ditemukan.');
        }

        $section->load(['learningModule', 'publishedLessons']);

        return view('views_user.learning-modules.section', compact('section'));
    }

    /**
     * Display a specific lesson
     */
    public function showLesson(LearningModuleLesson $lesson)
    {
        // Check if lesson, section, and module are published
        if (!$lesson->is_published || !$lesson->section->is_published || !$lesson->section->learningModule->is_published) {
            abort(404, 'Materi tidak ditemukan.');
        }

        // Increment views count
        $lesson->incrementViews();

        $lesson->load(['section.learningModule']);

        return view('views_user.learning-modules.lesson', compact('lesson'));
    }

    /**
     * Get learning modules by category (for AJAX)
     */
    public function getByCategory($category)
    {
        $modules = LearningModule::byCategory($category)
            ->published()
            ->with('sections')
            ->ordered()
            ->get();

        return response()->json(['modules' => $modules]);
    }

    /**
     * Get learning modules by subject (for AJAX)
     */
    public function getBySubject($subject)
    {
        $modules = LearningModule::bySubject($subject)
            ->published()
            ->with('sections')
            ->ordered()
            ->get();

        return response()->json(['modules' => $modules]);
    }

    /**
     * Get sections for a module (for AJAX)
     */
    public function getSections(LearningModule $learningModule)
    {
        // Check if module is published
        if (!$learningModule->is_published) {
            return response()->json(['error' => 'Modul tidak ditemukan'], 404);
        }

        $sections = $learningModule->publishedSections()
            ->with('publishedLessons')
            ->ordered()
            ->get();

        return response()->json(['sections' => $sections]);
    }

    /**
     * Get lessons for a section (for AJAX)
     */
    public function getLessons(LearningModuleSection $section)
    {
        // Check if section and module are published
        if (!$section->is_published || !$section->learningModule->is_published) {
            return response()->json(['error' => 'Section tidak ditemukan'], 404);
        }

        $lessons = $section->publishedLessons()->ordered()->get();

        return response()->json(['lessons' => $lessons]);
    }

    /**
     * Get featured learning modules
     */
    public function featured()
    {
        $modules = LearningModule::featured()
            ->published()
            ->with('sections')
            ->ordered()
            ->take(6)
            ->get();

        return response()->json(['modules' => $modules]);
    }

    /**
     * Search learning modules
     */
    public function search(Request $request)
    {
        $query = LearningModule::query();

        // Only published modules
        $query->published();

        // Search in title, description, and subtitle
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = '%' . $request->q . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('subtitle', 'like', $searchTerm);
            });
        }

        // Filter by category if provided
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        $modules = $query->with('sections')
            ->ordered()
            ->take(20)
            ->get();

        return response()->json(['modules' => $modules]);
    }

    /**
     * Get learning progress for user
     */
    public function getProgress(LearningModule $learningModule)
    {
        $user = Auth::user();
        
        // This would typically query a user progress table
        // For now, return basic module info with empty progress
        $learningModule->load(['sections.publishedLessons']);
        
        $progress = [
            'module_id' => $learningModule->id,
            'total_sections' => $learningModule->sections->count(),
            'completed_sections' => 0, // Would be calculated from progress data
            'total_lessons' => $learningModule->sections->sum(function($section) {
                return $section->lessons->count();
            }),
            'completed_lessons' => 0, // Would be calculated from progress data
            'completion_percentage' => 0
        ];

        return response()->json(['progress' => $progress]);
    }
}