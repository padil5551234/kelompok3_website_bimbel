@extends('layouts.user.app')

@section('title')
    Grafik Progres Nilai Tryout - DinasSolution
@endsection

@section('description')
    Pantau perkembangan nilai tryout Anda melalui grafik interaktif dan analisis detail performa akademik
@endsection

@section('content')
    <main id="main">
        <div class="container mb-4" style="margin-top: 124px">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border-radius: 10px; padding: 15px 20px;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}" style="color: #007bff; text-decoration: none;">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-chart-line me-1"></i>Grafik Progres Nilai
                    </li>
                </ol>
            </nav>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4 shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px;">
                        <div class="card-header border-0" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 20px 20px 0 0;">
                            <h3 class="card-title text-white mb-0"><i class="fas fa-chart-line me-2"></i><b>Grafik Progres Nilai Tryout</b></h3>
                            <p class="text-white-50 mb-0 mt-1">Pantau perkembangan kemampuan Anda melalui data tryout</p>
                        </div>
                        <div class="card-body">
                            @if($totalExams > 0)
                                <div class="row text-center mb-4">
                                    <div class="col-md-4 mb-3">
                                        <div class="progress-card" style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);">
                                            <div class="progress-icon">
                                                <i class="fas fa-trophy fa-3x text-white"></i>
                                            </div>
                                            <h3 class="progress-number text-white">{{ $totalScore }}</h3>
                                            <p class="progress-label text-white-50">Total Skor</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="progress-card" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                                            <div class="progress-icon">
                                                <i class="fas fa-clipboard-check fa-3x text-white"></i>
                                            </div>
                                            <h3 class="progress-number text-white">{{ $totalExams }}</h3>
                                            <p class="progress-label text-white-50">Tryout Diselesaikan</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="progress-card" style="background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);">
                                            <div class="progress-icon">
                                                <i class="fas fa-chart-line fa-3x text-white"></i>
                                            </div>
                                            <h3 class="progress-number text-white">{{ $averageScore }}</h3>
                                            <p class="progress-label text-white-50">Rata-rata Skor</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px;">
                                            <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                                                <h5 class="mb-0 text-primary"><i class="fas fa-chart-line"></i> Tren Perkembangan Nilai Tryout</h5>
                                                <small class="text-muted">Pantau perkembangan skor Anda dari waktu ke waktu</small>
                                            </div>
                                            <div class="card-body" style="padding: 30px;">
                                                <div style="position: relative; height: 450px;">
                                                    <canvas id="progressChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <div class="card border-0 shadow-sm" style="border-radius: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                            <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                                                <h5 class="mb-0 text-primary"><i class="fas fa-list-alt"></i> Detail Nilai per Tryout</h5>
                                                <small class="text-muted">Riwayat lengkap semua tryout yang telah diselesaikan</small>
                                            </div>
                                            <div class="card-body" style="padding: 0;">
                                                <div class="table-responsive">
                                                    <table class="table table-hover mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th style="padding: 20px 15px; border: none;"><i class="fas fa-calendar text-muted me-2"></i>Tanggal</th>
                                                                <th style="padding: 20px 15px; border: none;"><i class="fas fa-book text-muted me-2"></i>Nama Tryout</th>
                                                                <th style="padding: 20px 15px; border: none;"><i class="fas fa-star text-muted me-2"></i>Skor</th>
                                                                <th style="padding: 20px 15px; border: none;"><i class="fas fa-cogs text-muted me-2"></i>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($completedExams as $index => $exam)
                                                            <tr style="border: none; background: {{ $index % 2 == 0 ? 'rgba(255,255,255,0.8)' : 'rgba(255,255,255,0.4)' }};">
                                                                <td style="padding: 15px; vertical-align: middle;">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="bg-light rounded-circle p-2 me-3">
                                                                            <i class="fas fa-calendar-day text-primary"></i>
                                                                        </div>
                                                                        <div>
                                                                            <div class="fw-bold">{{ \Carbon\Carbon::parse($exam->created_at)->format('d M Y') }}</div>
                                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($exam->created_at)->format('H:i') }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="padding: 15px; vertical-align: middle;">
                                                                    <div class="fw-semibold">{{ $exam->ujian->nama }}</div>
                                                                    <small class="text-muted">{{ strtoupper($exam->ujian->jenis_ujian) }}</small>
                                                                </td>
                                                                <td style="padding: 15px; vertical-align: middle;">
                                                                    <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none;">
                                                                        <i class="fas fa-trophy me-1"></i>{{ $exam->nilai }}
                                                                    </span>
                                                                </td>
                                                                <td style="padding: 15px; vertical-align: middle;">
                                                                    <a href="{{ route('tryout.nilai', $exam->ujian_id) }}" class="btn btn-primary btn-sm px-3" style="border-radius: 20px; font-weight: 500;">
                                                                        <i class="fas fa-eye me-1"></i>Detail
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px; margin: 20px 0;">
                                    <div style="background: white; border-radius: 50%; width: 120px; height: 120px; margin: 0 auto 30px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                                    </div>
                                    <h4 class="text-dark mb-3">Belum ada data tryout</h4>
                                    <p class="text-muted mb-4" style="font-size: 1.1rem;">Selesaikan tryout terlebih dahulu untuk melihat grafik progres nilai Anda</p>
                                    <a href="{{ route('tryout.index') }}" class="btn btn-primary btn-lg px-4 py-3" style="border-radius: 25px; font-weight: 600; box-shadow: 0 5px 15px rgba(0,123,255,0.3);">
                                        <i class="fas fa-play me-2"></i>Mulai Tryout Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
<style>
/* Progress Section Styles */
.progress-card {
    border-radius: 20px;
    padding: 35px 25px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}

.progress-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.6) 50%, rgba(255,255,255,0.3) 100%);
}

.progress-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
}

.progress-icon {
    margin-bottom: 20px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
}

.progress-number {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 8px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    letter-spacing: -0.5px;
}

.progress-label {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Additional animations and effects */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.progress-card {
    animation: fadeInUp 0.8s ease-out;
}

.progress-card:nth-child(1) { animation-delay: 0.1s; }
.progress-card:nth-child(2) { animation-delay: 0.2s; }
.progress-card:nth-child(3) { animation-delay: 0.3s; }

.card {
    animation: slideInLeft 1s ease-out;
}

.card:nth-child(1) { animation-delay: 0.2s; }
.card:nth-child(2) { animation-delay: 0.4s; }
.card:nth-child(3) { animation-delay: 0.6s; }

/* Chart container styling */
.chart-container {
    position: relative;
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

/* Table styling improvements */
.table {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.9);
}

.table thead th {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border: none;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
    padding: 20px 15px;
}

.table tbody tr {
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    border: none;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, rgba(0, 123, 255, 0.08) 0%, rgba(0, 123, 255, 0.05) 100%);
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.1);
}

@media (max-width: 768px) {
    .progress-number {
        font-size: 2.5rem;
    }

    .progress-card {
        padding: 25px 20px;
    }

    .chart-container {
        padding: 15px;
    }
}
</style>
@endpush

@push('scripts')
@if($totalExams > 0)
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('progressChart').getContext('2d');
        const scores = @json($scores);
        const dates = @json($dates->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d/m');
        }));
        const examNames = @json($examNames);

        // Create gradient
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 123, 255, 0.3)');
        gradient.addColorStop(1, 'rgba(0, 123, 255, 0.05)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Skor Tryout',
                    data: scores,
                    borderColor: '#007bff',
                    backgroundColor: gradient,
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#007bff',
                    pointBorderWidth: 3,
                    pointRadius: 8,
                    pointHoverRadius: 12,
                    pointHoverBackgroundColor: '#007bff',
                    pointHoverBorderColor: '#ffffff',
                    pointHoverBorderWidth: 3,
                    shadowOffsetX: 3,
                    shadowOffsetY: 3,
                    shadowBlur: 10,
                    shadowColor: 'rgba(0, 123, 255, 0.3)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2500,
                    easing: 'easeInOutQuart',
                    onComplete: function() {
                        // Add a subtle glow effect after animation
                        const canvas = document.getElementById('progressChart');
                        canvas.style.boxShadow = '0 0 20px rgba(0, 123, 255, 0.2)';
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                const index = context[0].dataIndex;
                                return examNames[index] || 'Tryout';
                            },
                            label: function(context) {
                                return 'Skor: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: Math.max(0, Math.min(...scores) - 10),
                        grid: {
                            color: 'rgba(0,0,0,0.08)',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 12,
                                weight: '500'
                            },
                            padding: 10
                        },
                        border: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.08)',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 11,
                                weight: '500'
                            },
                            padding: 10,
                            maxRotation: 45,
                            minRotation: 45
                        },
                        border: {
                            color: 'rgba(0,0,0,0.1)'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                elements: {
                    point: {
                        hoverRadius: 12
                    }
                }
            }
        });
    });
</script>
@endif
@endpush