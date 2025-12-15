@extends('layouts.user.app')

@section('title')
    Raport Belajar - DinasSolution
@endsection

@section('description')
    Pantau perkembangan belajar Anda melalui raport komprehensif dan analisis detail performa akademik
@endsection

@section('content')
    <main id="main">
        <div class="container mb-4" style="margin-top: 124px">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="raport-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 30px; color: white; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -50%; right: -10%; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                        <div style="position: absolute; bottom: -30%; left: -5%; width: 150px; height: 150px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="mb-2" style="font-size: 2.5rem; font-weight: 700;">
                                    <i class="fas fa-graduation-cap me-3"></i>Raport Belajar Saya
                                </h1>
                                <p class="mb-0 opacity-75" style="font-size: 1.1rem;">
                                    Pantau perkembangan dan capaian pembelajaran Anda secara detail
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="raport-date" style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 15px; backdrop-filter: blur(10px);">
                                    <div style="font-size: 0.9rem; opacity: 0.8;">Terakhir diperbarui</div>
                                    <div style="font-size: 1.2rem; font-weight: 600;">{{ now()->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($stats['total_tryouts'] > 0)
                <!-- Overall Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 25px; color: white; box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3); transition: all 0.3s ease;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 5px;">Total Tryout</div>
                                            <div style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['total_tryouts'] }}</div>
                                        </div>
                                        <div style="font-size: 3rem; opacity: 0.3;">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 20px; padding: 25px; color: white; box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3); transition: all 0.3s ease;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 5px;">Rata-rata Skor</div>
                                            <div style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['average_score'] }}</div>
                                        </div>
                                        <div style="font-size: 3rem; opacity: 0.3;">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 20px; padding: 25px; color: white; box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3); transition: all 0.3s ease;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 5px;">Skor Terbaik</div>
                                            <div style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['best_score'] }}</div>
                                        </div>
                                        <div style="font-size: 3rem; opacity: 0.3;">
                                            <i class="fas fa-trophy"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 20px; padding: 25px; color: white; box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3); transition: all 0.3s ease;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div style="font-size: 0.9rem; opacity: 0.8; margin-bottom: 5px;">Tingkat Keberhasilan</div>
                                            <div style="font-size: 2.5rem; font-weight: 700; margin: 0;">{{ $stats['success_rate'] }}%</div>
                                        </div>
                                        <div style="font-size: 3rem; opacity: 0.3;">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance Trends and Subject Analysis -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                            <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-chart-area me-2"></i>Tren Perkembangan Skor
                                </h5>
                                <small class="text-muted">Pantau kemajuan Anda dari bulan ke bulan</small>
                            </div>
                            <div class="card-body" style="padding: 30px;">
                                <div style="position: relative; height: 300px;">
                                    <canvas id="trendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                            <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-medal me-2"></i>Prestasi & Pencapaian
                                </h5>
                                <small class="text-muted">Milestone yang telah您 raih</small>
                            </div>
                            <div class="card-body" style="padding: 20px;">
                                @foreach($achievements as $achievement)
                                    <div class="achievement-item mb-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; border-left: 4px solid #007bff;">
                                        <div class="d-flex align-items-center">
                                            <div style="font-size: 2rem; margin-right: 15px;">{{ $achievement['icon'] }}</div>
                                            <div>
                                                <div style="font-weight: 600; color: #333;">{{ $achievement['title'] }}</div>
                                                <div style="font-size: 0.85rem; color: #666;">{{ $achievement['description'] }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Tryouts and Subject Performance -->
                <div class="row mb-4">
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                            <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-history me-2"></i>Riwayat Tryout Terbaru
                                </h5>
                                <small class="text-muted">10 tryout terakhir yang diselesaikan</small>
                            </div>
                            <div class="card-body" style="padding: 0; max-height: 400px; overflow-y: auto;">
                                @foreach($recentTryouts as $tryout)
                                    <div class="tryout-item p-3 border-bottom" style="border-color: #f0f0f0;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="flex-grow-1">
                                                <div style="font-weight: 600; color: #333;">{{ $tryout['ujian_name'] }}</div>
                                                <div class="text-muted" style="font-size: 0.85rem;">{{ $tryout['jenis_ujian'] }} • {{ $tryout['date'] }}</div>
                                                <div class="text-muted" style="font-size: 0.8rem;">Durasi: {{ $tryout['duration'] }}</div>
                                            </div>
                                            <div class="text-end">
                                                <div class="score-badge" style="background: {{ $tryout['score'] >= 75 ? '#28a745' : ($tryout['score'] >= 65 ? '#ffc107' : '#dc3545') }}; color: white; padding: 8px 15px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                                                    {{ $tryout['score'] }}
                                                </div>
                                                <div style="font-size: 0.75rem; color: #666; margin-top: 5px;">
                                                    {{ $tryout['performance_level'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                            <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-chart-pie me-2"></i>Analisis per Jenis Ujian
                                </h5>
                                <small class="text-muted">Performa berdasarkan kategori ujian</small>
                            </div>
                            <div class="card-body" style="padding: 20px;">
                                @foreach($subjectPerformance as $subject => $data)
                                    <div class="subject-item mb-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div style="font-weight: 600; color: #333; text-transform: uppercase;">{{ $subject }}</div>
                                            <div class="badge" style="background: #007bff; color: white;">{{ $data['average'] }}</div>
                                        </div>
                                        <div class="progress mb-2" style="height: 8px; border-radius: 10px; background: #e9ecef;">
                                            <div class="progress-bar" style="width: {{ $data['average'] }}%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;"></div>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 0.8rem; color: #666;">
                                            <span>{{ $data['count'] }} tryout</span>
                                            <span>Trend: {{ ucfirst($data['trend']) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Learning Timeline -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                            <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-clock me-2"></i>Timeline Aktivitas Belajar
                                </h5>
                                <small class="text-muted">Riwayat lengkap aktivitas pembelajaran Anda</small>
                            </div>
                            <div class="card-body" style="padding: 30px;">
                                <div class="timeline">
                                    @foreach($learningTimeline as $activity)
                                        <div class="timeline-item mb-4 pb-4" style="border-left: 3px solid #e9ecef; padding-left: 25px; position: relative;">
                                            <div class="timeline-marker" style="position: absolute; left: -8px; top: 0; width: 14px; height: 14px; background: #007bff; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 0 3px #007bff;"></div>
                                            <div class="timeline-content">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <div style="font-weight: 600; color: #333;">{{ $activity['description'] }}</div>
                                                        <div style="font-size: 0.85rem; color: #666;">{{ $activity['date'] }}</div>
                                                    </div>
                                                    <div class="text-muted" style="font-size: 1.5rem;">{{ $activity['icon'] }}</div>
                                                </div>
                                                @if($activity['score'])
                                                    <div class="badge" style="background: #28a745; color: white;">Skor: {{ $activity['score'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                @if(count($recommendations) > 0)
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: linear-gradient(135deg, #fff5e6 0%, #ffe6cc 100%); border-left: 5px solid #ff9500;">
                            <div class="card-header border-0" style="background: transparent; border-radius: 20px 20px 0 0; padding: 25px;">
                                <h5 class="mb-0" style="color: #cc7000;">
                                    <i class="fas fa-lightbulb me-2"></i>Rekomendasi Personal
                                </h5>
                                <small class="text-muted">Saran untuk meningkatkan performa belajar Anda</small>
                            </div>
                            <div class="card-body" style="padding: 25px;">
                                <div class="row">
                                    @foreach($recommendations as $recommendation)
                                        <div class="col-lg-6 mb-3">
                                            <div class="recommendation-item p-3" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                                <div class="d-flex align-items-start">
                                                    <div class="recommendation-icon me-3" style="width: 40px; height: 40px; background: {{ $recommendation['priority'] == 'high' ? '#dc3545' : ($recommendation['priority'] == 'medium' ? '#ffc107' : '#28a745') }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                        !
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div style="font-weight: 600; color: #333; margin-bottom: 5px;">{{ $recommendation['title'] }}</div>
                                                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 10px;">{{ $recommendation['description'] }}</div>
                                                        <div class="badge" style="background: #007bff; color: white; font-size: 0.8rem;">{{ $recommendation['action'] }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Export and Actions -->
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                            <div class="card-body text-center" style="padding: 30px;">
                                <h5 class="mb-3" style="color: #333;">
                                    <i class="fas fa-download me-2"></i>Ekspor dan Bagikan Raport
                                </h5>
                                <p class="text-muted mb-4">Simpan atau bagikan raport pembelajaran Anda</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('raport.export-pdf') }}" class="btn btn-primary btn-lg px-4 py-3" style="border-radius: 25px; font-weight: 600; box-shadow: 0 5px 15px rgba(0,123,255,0.3);">
                                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                                    </a>
                                    <button class="btn btn-outline-primary btn-lg px-4 py-3" onclick="shareReport()" style="border-radius: 25px; font-weight: 600;">
                                        <i class="fas fa-share-alt me-2"></i>Bagikan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px; margin: 20px 0;">
                            <div style="background: white; border-radius: 50%; width: 120px; height: 120px; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                            </div>
                            <h4 class="text-dark mb-3">Belum Ada Data Raport</h4>
                            <p class="text-muted mb-4" style="font-size: 1.1rem;">Selesaikan tryout pertama Anda untuk melihat raport pembelajaran yang komprehensif</p>
                            <a href="{{ route('tryout.index') }}" class="btn btn-primary btn-lg px-4 py-3" style="border-radius: 25px; font-weight: 600; box-shadow: 0 5px 15px rgba(0,123,255,0.3);">
                                <i class="fas fa-play me-2"></i>Mulai Tryout Pertama
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection

@push('styles')
<style>
/* Custom animations and effects */
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
}

.timeline-item:last-child {
    border-left-color: transparent;
}

/* Scrollbar styling */
.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.card-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .raport-header h1 {
        font-size: 2rem !important;
    }
    
    .stat-card {
        margin-bottom: 15px;
    }
    
    .stat-card div:last-child {
        font-size: 2rem !important;
    }
}
</style>
@endpush

@push('scripts')
@if($stats['total_tryouts'] > 0)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const trendData = @json($trends);
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.map(item => item.month),
                datasets: [{
                    label: 'Rata-rata Skor',
                    data: trendData.map(item => item.average_score),
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Jumlah Tryout',
                    data: trendData.map(item => item.tryouts),
                    borderColor: '#f093fb',
                    backgroundColor: 'rgba(240, 147, 251, 0.1)',
                    borderWidth: 3,
                    fill: false,
                    tension: 0.4,
                    pointBackgroundColor: '#f093fb',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return 'Rata-rata Skor: ' + context.parsed.y;
                                } else {
                                    return 'Jumlah Tryout: ' + context.parsed.y;
                                }
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Rata-rata Skor'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Jumlah Tryout'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });
    });


    function shareReport() {
        if (navigator.share) {
            navigator.share({
                title: 'Raport Belajar Saya',
                text: 'Lihat perkembangan belajar saya di DinasSolution',
                url: window.location.href
            });
        } else {
            // Fallback for browsers that don't support Web Share API
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link raport berhasil disalin ke clipboard!');
            });
        }
    }
</script>
@endif
@endpush