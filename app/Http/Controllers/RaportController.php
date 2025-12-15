<?php

namespace App\Http\Controllers;

use App\Models\UjianUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RaportController extends Controller
{
    public function index()
    {
        try {
            $userId = auth()->user()->id;
            
            // Optimized query with proper eager loading
            $completedTryouts = UjianUser::with(['ujian:id,nama,jenis_ujian'])
                ->where('user_id', $userId)
                ->where('status', 2)
                ->select(['id', 'ujian_id', 'nilai', 'created_at', 'waktu_mulai', 'waktu_akhir'])
                ->orderBy('created_at', 'desc')
                ->get();

            $totalTryouts = $completedTryouts->count();
            
            // Calculate statistics efficiently
            $stats = [
                'total_tryouts' => $totalTryouts,
                'average_score' => 0,
                'best_score' => 0,
                'success_rate' => 0
            ];

            if ($totalTryouts > 0) {
                $scores = $completedTryouts->pluck('nilai')->filter();
                $stats['average_score'] = $scores->isNotEmpty() ? round($scores->avg(), 1) : 0;
                $stats['best_score'] = $scores->isNotEmpty() ? $scores->max() : 0;
                
                $passedCount = $scores->filter(function($score) {
                    return $score >= 65;
                })->count();
                $stats['success_rate'] = round(($passedCount / $totalTryouts) * 100, 1);
            }

            // Process recent tryouts with performance levels
            $recentTryouts = $completedTryouts->take(10)->map(function ($tryout) {
                $duration = '-';
                if ($tryout->waktu_mulai && $tryout->waktu_akhir) {
                    $minutes = Carbon::parse($tryout->waktu_mulai)->diffInMinutes(Carbon::parse($tryout->waktu_akhir));
                    $duration = $minutes . ' menit';
                }

                return [
                    'ujian_name' => $tryout->ujian ? ($tryout->ujian->nama ?? 'Tryout') : 'Tryout',
                    'jenis_ujian' => $tryout->ujian ? ucfirst($tryout->ujian->jenis_ujian ?? 'umum') : 'Umum',
                    'date' => $tryout->created_at->format('d M Y'),
                    'duration' => $duration,
                    'score' => $tryout->nilai ?? 0,
                    'performance_level' => $this->getPerformanceLevel($tryout->nilai)
                ];
            })->values();

            // Group by subject type for performance analysis
            $subjectPerformance = [];
            if ($totalTryouts > 0) {
                $groupedByType = $completedTryouts->groupBy(function($item) {
                    return $item->ujian ? ($item->ujian->jenis_ujian ?? 'umum') : 'umum';
                });

                foreach ($groupedByType as $type => $tryouts) {
                    $scores = $tryouts->pluck('nilai')->filter();
                    $subjectPerformance[ucfirst($type)] = [
                        'average' => $scores->isNotEmpty() ? round($scores->avg(), 1) : 0,
                        'count' => $tryouts->count(),
                        'trend' => $this->calculateTrend($scores)
                    ];
                }
            }

            // Generate achievements based on performance
            $achievements = $this->generateAchievements($totalTryouts, $stats['best_score'], $stats['success_rate']);

            // Generate recommendations
            $recommendations = [];
            if ($totalTryouts == 0) {
                $recommendations[] = [
                    'priority' => 'high',
                    'title' => 'Mulai Latihan',
                    'description' => 'Lakukan tryout pertama untuk memulai perjalanan belajar Anda',
                    'action' => 'Mulai Tryout'
                ];
            }

            // Create learning timeline
            $learningTimeline = $completedTryouts->map(function ($tryout) {
                return [
                    'description' => "Menyelesaikan " . ($tryout->ujian ? ($tryout->ujian->nama ?? 'Tryout') : 'Tryout'),
                    'date' => $tryout->created_at->format('d M Y H:i'),
                    'icon' => '📝',
                    'score' => $tryout->nilai ?? 0
                ];
            })->values();

            // Placeholder for trends (can be enhanced later)
            $trends = [];

            return view('views_user.raport.index', compact(
                'stats', 'recentTryouts', 'subjectPerformance',
                'achievements', 'recommendations', 'learningTimeline', 'trends'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in raport index: ' . $e->getMessage());
            return view('views_user.raport.index', [
                'stats' => ['total_tryouts' => 0, 'average_score' => 0, 'best_score' => 0, 'success_rate' => 0],
                'recentTryouts' => collect(),
                'subjectPerformance' => [],
                'achievements' => [],
                'recommendations' => [['priority' => 'high', 'title' => 'Terjadi Kesalahan', 'description' => 'Silakan muat ulang halaman', 'action' => 'Muat Ulang']],
                'learningTimeline' => collect(),
                'trends' => []
            ]);
        }
    }

    /**
     * Determine performance level based on score
     */
    private function getPerformanceLevel($score)
    {
        if (!$score) return 'Belum Ada Nilai';
        if ($score >= 85) return 'Sangat Baik';
        if ($score >= 70) return 'Baik';
        if ($score >= 65) return 'Cukup';
        return 'Perlu Perbaikan';
    }

    /**
     * Calculate trend based on scores
     */
    private function calculateTrend($scores)
    {
        if ($scores->count() < 3) return 'stabil';
        
        $recent = $scores->take(3)->values();
        $older = $scores->skip(3)->take(3)->values();
        
        if ($recent->isEmpty() || $older->isEmpty()) return 'stabil';
        
        $recentAvg = $recent->avg();
        $olderAvg = $older->avg();
        
        $difference = $recentAvg - $olderAvg;
        
        if ($difference > 5) return 'naik';
        if ($difference < -5) return 'turun';
        return 'stabil';
    }

    /**
     * Generate achievements based on performance
     */
    private function generateAchievements($totalTryouts, $bestScore, $successRate)
    {
        $achievements = [];
        
        if ($totalTryouts >= 1) {
            $achievements[] = [
                'icon' => '🎯',
                'title' => 'Langkah Pertama',
                'description' => 'Menyelesaikan tryout pertama Anda'
            ];
        }
        
        if ($bestScore >= 85) {
            $achievements[] = [
                'icon' => '🏆',
                'title' => 'Perolehan Nilai Tinggi',
                'description' => 'Mencapai nilai di atas 85'
            ];
        }
        
        if ($successRate >= 80 && $totalTryouts >= 3) {
            $achievements[] = [
                'icon' => '📈',
                'title' => 'Konsistensi Tinggi',
                'description' => 'Tingkat kelulusan di atas 80%'
            ];
        }
        
        if ($totalTryouts >= 10) {
            $achievements[] = [
                'icon' => '💪',
                'title' => 'Semangat Belajar',
                'description' => 'Menyelesaikan 10+ tryout'
            ];
        }
        
        return $achievements;
    }

    public function detailExam($ujianUserId)
    {
        // Validate input parameter
        if (!$ujianUserId || !is_string($ujianUserId) && !is_numeric($ujianUserId)) {
            abort(404, 'ID tryout tidak valid');
        }

        try {
            $ujianUser = UjianUser::with([
                'ujian',
                'jawabanPeserta.soal',
                'jawabanPeserta.soal.jawaban'
            ])
            ->where('user_id', auth()->user()->id)
            ->find($ujianUserId);

            if (!$ujianUser) {
                abort(404, 'Data tryout tidak ditemukan atau tidak memiliki akses');
            }

            // Ensure the user has completed the test
            if ($ujianUser->status != 2) {
                abort(403, 'Tryout belum selesai');
            }

            $totalDuration = 0;
            if ($ujianUser->waktu_mulai && $ujianUser->waktu_akhir) {
                $totalDuration = Carbon::parse($ujianUser->waktu_mulai)->diffInMinutes(Carbon::parse($ujianUser->waktu_akhir));
            }
            
            $totalQuestions = $ujianUser->jawabanPeserta->count();
            $averageTimePerQuestion = $totalQuestions > 0 ? round($totalDuration / $totalQuestions, 1) : 0;

            // Initialize question analysis for SKD type
            $questionAnalysis = [];
            if ($ujianUser->ujian && $ujianUser->ujian->jenis_ujian == 'skd') {
                $questionAnalysis = [
                    'twk' => ['total' => 0, 'correct' => 0, 'percentage' => 0],
                    'tiu' => ['total' => 0, 'correct' => 0, 'percentage' => 0],
                    'tkp' => ['total' => 0, 'correct' => 0, 'percentage' => 0]
                ];

                // Calculate SKD statistics if available
                foreach ($ujianUser->jawabanPeserta as $jawaban) {
                    if ($jawaban->soal && $jawaban->soal->jenis_soal) {
                        $jenis = $jawaban->soal->jenis_soal;
                        if (isset($questionAnalysis[$jenis])) {
                            $questionAnalysis[$jenis]['total']++;
                            if ($jawaban->jawaban_id == $jawaban->soal->kunci_jawaban) {
                                $questionAnalysis[$jenis]['correct']++;
                            }
                        }
                    }
                }

                // Calculate percentages
                foreach ($questionAnalysis as $key => &$analysis) {
                    $analysis['percentage'] = $analysis['total'] > 0
                        ? round(($analysis['correct'] / $analysis['total']) * 100, 1)
                        : 0;
                }
            }

            return view('views_user.raport.detail-exam', compact(
                'ujianUser', 'averageTimePerQuestion', 'questionAnalysis'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in detailExam: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat detail tryout');
        }
    }

    public function exportPdf()
    {
        try {
            $userId = auth()->user()->id;

            // Get the same data as index
            $completedTryouts = UjianUser::with(['ujian:id,nama,jenis_ujian'])
                ->where('user_id', $userId)
                ->where('status', 2)
                ->select(['id', 'ujian_id', 'nilai', 'created_at', 'waktu_mulai', 'waktu_akhir'])
                ->orderBy('created_at', 'desc')
                ->get();

            $totalTryouts = $completedTryouts->count();

            $stats = [
                'total_tryouts' => $totalTryouts,
                'average_score' => 0,
                'best_score' => 0,
                'success_rate' => 0
            ];

            if ($totalTryouts > 0) {
                $scores = $completedTryouts->pluck('nilai')->filter();
                $stats['average_score'] = $scores->isNotEmpty() ? round($scores->avg(), 1) : 0;
                $stats['best_score'] = $scores->isNotEmpty() ? $scores->max() : 0;

                $passedCount = $scores->filter(function($score) {
                    return $score >= 65;
                })->count();
                $stats['success_rate'] = round(($passedCount / $totalTryouts) * 100, 1);
            }

            $recentTryouts = $completedTryouts->take(10)->map(function ($tryout) {
                $duration = '-';
                if ($tryout->waktu_mulai && $tryout->waktu_akhir) {
                    $minutes = Carbon::parse($tryout->waktu_mulai)->diffInMinutes(Carbon::parse($tryout->waktu_akhir));
                    $duration = $minutes . ' menit';
                }

                return [
                    'ujian_name' => $tryout->ujian ? ($tryout->ujian->nama ?? 'Tryout') : 'Tryout',
                    'jenis_ujian' => $tryout->ujian ? ucfirst($tryout->ujian->jenis_ujian ?? 'umum') : 'Umum',
                    'date' => $tryout->created_at->format('d M Y'),
                    'duration' => $duration,
                    'score' => $tryout->nilai ?? 0,
                    'performance_level' => $this->getPerformanceLevel($tryout->nilai)
                ];
            })->values();

            $subjectPerformance = [];
            if ($totalTryouts > 0) {
                $groupedByType = $completedTryouts->groupBy(function($item) {
                    return $item->ujian ? ($item->ujian->jenis_ujian ?? 'umum') : 'umum';
                });

                foreach ($groupedByType as $type => $tryouts) {
                    $scores = $tryouts->pluck('nilai')->filter();
                    $subjectPerformance[ucfirst($type)] = [
                        'average' => $scores->isNotEmpty() ? round($scores->avg(), 1) : 0,
                        'count' => $tryouts->count(),
                        'trend' => $this->calculateTrend($scores)
                    ];
                }
            }

            $achievements = $this->generateAchievements($totalTryouts, $stats['best_score'], $stats['success_rate']);

            $recommendations = [];
            if ($totalTryouts == 0) {
                $recommendations[] = [
                    'priority' => 'high',
                    'title' => 'Mulai Latihan',
                    'description' => 'Lakukan tryout pertama untuk memulai perjalanan belajar Anda',
                    'action' => 'Mulai Tryout'
                ];
            }

            $learningTimeline = $completedTryouts->map(function ($tryout) {
                return [
                    'description' => "Menyelesaikan " . ($tryout->ujian ? ($tryout->ujian->nama ?? 'Tryout') : 'Tryout'),
                    'date' => $tryout->created_at->format('d M Y H:i'),
                    'icon' => '📝',
                    'score' => $tryout->nilai ?? 0
                ];
            })->values();

            $trends = [];

            // Generate PDF
            $pdf = Pdf::loadView('views_user.raport.pdf', compact(
                'stats', 'recentTryouts', 'subjectPerformance',
                'achievements', 'recommendations', 'learningTimeline', 'trends'
            ));

            $filename = 'raport-belajar-' . auth()->user()->name . '-' . now()->format('Y-m-d') . '.pdf';

            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('Error in exportPdf: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat membuat PDF'], 500);
        }
    }
}