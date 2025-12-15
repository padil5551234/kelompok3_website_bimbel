@extends('layouts.user.app')

@section('title')
    Detail Raport - {{ $ujianUser->ujian->nama }}
@endsection

@section('content')
    <main id="main">
        <div class="container mb-4" style="margin-top: 124px">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); border-radius: 10px; padding: 15px 20px;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('raport.index') }}" style="color: #007bff; text-decoration: none;">
                            <i class="fas fa-graduation-cap me-1"></i>Raport Belajar
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-chart-bar me-1"></i>Detail {{ $ujianUser->ujian->nama }}
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="detail-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; padding: 30px; color: white;">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="mb-2" style="font-size: 2.5rem; font-weight: 700;">
                                    <i class="fas fa-clipboard-check me-3"></i>{{ $ujianUser->ujian->nama }}
                                </h1>
                                <p class="mb-0 opacity-75" style="font-size: 1.1rem;">
                                    Detail analisis performa ujian Anda
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="score-display" style="background: rgba(255,255,255,0.2); padding: 20px; border-radius: 15px; backdrop-filter: blur(10px);">
                                    <div style="font-size: 1rem; opacity: 0.8;">Skor Akhir</div>
                                    <div style="font-size: 3rem; font-weight: 700;">{{ $ujianUser->nilai }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card text-center" style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div style="font-size: 2.5rem; color: #28a745; margin-bottom: 10px;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 600; color: #333;">{{ $averageTimePerQuestion }}</div>
                        <div style="font-size: 0.9rem; color: #666;">Menit/Soal</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card text-center" style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div style="font-size: 2.5rem; color: #007bff; margin-bottom: 10px;">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 600; color: #333;">{{ \Carbon\Carbon::parse($ujianUser->created_at)->format('d M Y') }}</div>
                        <div style="font-size: 0.9rem; color: #666;">Tanggal Ujian</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card text-center" style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div style="font-size: 2.5rem; color: #ffc107; margin-bottom: 10px;">
                            <i class="fas fa-stopwatch"></i>
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 600; color: #333;">{{ \Carbon\Carbon::parse($ujianUser->waktu_mulai)->diffInMinutes(\Carbon\Carbon::parse($ujianUser->waktu_akhir)) }}</div>
                        <div style="font-size: 0.9rem; color: #666;">Menit Total</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card text-center" style="background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <div style="font-size: 2.5rem; color: #17a2b8; margin-bottom: 10px;">
                            <i class="fas fa-list-ol"></i>
                        </div>
                        <div style="font-size: 1.5rem; font-weight: 600; color: #333;">{{ $ujianUser->jawabanPeserta->count() }}</div>
                        <div style="font-size: 0.9rem; color: #666;">Total Soal</div>
                    </div>
                </div>
            </div>

            <!-- Question Type Analysis for SKD -->
            @if($ujianUser->ujian->jenis_ujian == 'skd' && count($questionAnalysis) > 0)
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-chart-pie me-2"></i>Analisis per Jenis Soal (SKD)
                            </h5>
                            <small class="text-muted">Performance breakdown untuk TWK, TIU, dan TKP</small>
                        </div>
                        <div class="card-body" style="padding: 30px;">
                            <div class="row">
                                @foreach($questionAnalysis as $type => $analysis)
                                    <div class="col-lg-4 mb-4">
                                        <div class="question-type-card p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 15px; border-left: 5px solid #007bff;">
                                            <div class="text-center mb-3">
                                                <h3 style="font-weight: 700; color: #007bff; margin: 0; font-size: 2rem;">{{ strtoupper($type) }}</h3>
                                            </div>
                                            <div class="text-center mb-3">
                                                <div style="font-size: 3rem; font-weight: 700; color: {{ $analysis['percentage'] >= 70 ? '#28a745' : ($analysis['percentage'] >= 50 ? '#ffc107' : '#dc3545') }};">
                                                    {{ $analysis['percentage'] }}%
                                                </div>
                                                <div style="color: #666; font-size: 0.9rem;">Tingkat Keberhasilan</div>
                                            </div>
                                            <div class="progress mb-3" style="height: 10px; border-radius: 10px; background: #e9ecef;">
                                                <div class="progress-bar" style="width: {{ $analysis['percentage'] }}%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;"></div>
                                            </div>
                                            <div class="d-flex justify-content-between" style="font-size: 0.9rem; color: #666;">
                                                <span><strong>{{ $analysis['correct'] }}</strong> benar</span>
                                                <span>dari <strong>{{ $analysis['total'] }}</strong> soal</span>
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

            <!-- Performance Summary -->
            <div class="row mb-4">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-chart-line me-2"></i>Ringkasan Performa
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 30px;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="performance-metric">
                                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">Soal Terjawab</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: #28a745;">
                                            {{ $ujianUser->jawabanPeserta->where('jawaban_id', '!=', null)->count() }}
                                            <span style="font-size: 1rem; color: #666;">/ {{ $ujianUser->jawabanPeserta->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="performance-metric">
                                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">Soal Dilewati</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: #dc3545;">
                                            {{ $ujianUser->jawabanPeserta->where('jawaban_id', null)->count() }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="performance-metric">
                                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">Tingkat Penyelesaian</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: #007bff;">
                                            {{ round(($ujianUser->jawabanPeserta->where('jawaban_id', '!=', null)->count() / $ujianUser->jawabanPeserta->count()) * 100, 1) }}%
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="performance-metric">
                                        <div style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">Status Kelulusan</div>
                                        <div style="font-size: 1.5rem; font-weight: 700; color: {{ $ujianUser->nilai >= 65 ? '#28a745' : '#dc3545' }};">
                                            {{ $ujianUser->nilai >= 65 ? 'LULUS' : 'TIDAK LULUS' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-lightbulb me-2"></i>Saran Perbaikan
                            </h5>
                        </div>
                        <div class="card-body" style="padding: 25px;">
                            @if($ujianUser->nilai >= 80)
                                <div class="alert alert-success" role="alert">
                                    <h6><i class="fas fa-star me-2"></i>Performa Excellent!</h6>
                                    <p class="mb-0">Skor Anda sangat memuaskan. Tetap konsisten dan tantangi ujian yang lebih sulit.</p>
                                </div>
                            @elseif($ujianUser->nilai >= 65)
                                <div class="alert alert-warning" role="alert">
                                    <h6><i class="fas fa-thumbs-up me-2"></i>Good Job!</h6>
                                    <p class="mb-0">Anda lulus, tapi masih ada ruang untuk improvement. Fokus pada soal-soal yang belum dikuasai.</p>
                                </div>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perlu Perbaikan</h6>
                                    <p class="mb-0">Skor masih di bawah standar. Disarankan untuk lebih sering latihan dan meninjau materi.</p>
                                </div>
                            @endif

                            @if($ujianUser->jawabanPeserta->where('jawaban_id', null)->count() > 0)
                                <div class="alert alert-info" role="alert">
                                    <h6><i class="fas fa-info-circle me-2"></i>Tips</h6>
                                    <p class="mb-0">Anda masih memiliki {{ $ujianUser->jawabanPeserta->where('jawaban_id', null)->count() }} soal yang belum dijawab. Usahakan untuk menjawab semua soal pada ujian berikutnya.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Answer Review -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px 20px 0 0; padding: 25px;">
                            <h5 class="mb-0 text-primary">
                                <i class="fas fa-list-alt me-2"></i>Review Jawaban
                            </h5>
                            <small class="text-muted">Detail jawaban Anda untuk setiap soal</small>
                        </div>
                        <div class="card-body" style="padding: 0; max-height: 600px; overflow-y: auto;">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white;">
                                            <th style="padding: 20px 15px; border: none; font-weight: 600;">No. Soal</th>
                                            <th style="padding: 20px 15px; border: none; font-weight: 600;">Jawaban Anda</th>
                                            <th style="padding: 20px 15px; border: none; font-weight: 600;">Kunci Jawaban</th>
                                            <th style="padding: 20px 15px; border: none; font-weight: 600;">Status</th>
                                            <th style="padding: 20px 15px; border: none; font-weight: 600;"> Poin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ujianUser->jawabanPeserta as $key => $jawaban)
                                            <tr>
                                                <td style="padding: 15px; border: none;">{{ $key + 1 }}</td>
                                                <td style="padding: 15px; border: none;">
                                                    @if($jawaban->jawaban_id)
                                                        @foreach($jawaban->soal->jawaban as $key => $jwb)
                                                            @if($jwb->id == $jawaban->jawaban_id)
                                                                <span class="badge" style="background: #6c757d; color: white; font-size: 0.9rem; padding: 8px 12px;">
                                                                    {{ chr($key + 65) }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <span class="badge" style="background: #dc3545; color: white;">-</span>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px; border: none;">
                                                    @foreach($jawaban->soal->jawaban as $key => $jwb)
                                                        @if($jawaban->soal->jenis_soal == 'tkp')
                                                            @if($jwb->point == 5)
                                                                <span class="badge" style="background: #28a745; color: white; font-size: 0.9rem; padding: 8px 12px;">
                                                                    {{ chr($key + 65) }}
                                                                </span>
                                                            @endif
                                                        @else
                                                            @if($jwb->id == $jawaban->soal->kunci_jawaban)
                                                                <span class="badge" style="background: #28a745; color: white; font-size: 0.9rem; padding: 8px 12px;">
                                                                    {{ chr($key + 65) }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td style="padding: 15px; border: none;">
                                                    @if($jawaban->jawaban_id == $jawaban->soal->kunci_jawaban)
                                                        <span class="badge" style="background: #28a745; color: white;">
                                                            <i class="fas fa-check me-1"></i>Benar
                                                        </span>
                                                    @elseif(!$jawaban->jawaban_id)
                                                        <span class="badge" style="background: #6c757d; color: white;">
                                                            <i class="fas fa-minus me-1"></i>Kosong
                                                        </span>
                                                    @else
                                                        <span class="badge" style="background: #dc3545; color: white;">
                                                            <i class="fas fa-times me-1"></i>Salah
                                                        </span>
                                                    @endif
                                                </td>
                                                <td style="padding: 15px; border: none;">
                                                    <span class="badge" style="background: {{ $jawaban->poin > 0 ? '#28a745' : '#dc3545' }}; color: white;">
                                                        {{ $jawaban->poin }}
                                                    </span>
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

            <!-- Actions -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
                        <div class="card-body text-center" style="padding: 30px;">
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('raport.index') }}" class="btn btn-outline-primary btn-lg px-4 py-3" style="border-radius: 25px; font-weight: 600;">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Raport
                                </a>
                                <a href="{{ route('tryout.nilai', $ujianUser->ujian_id) }}" class="btn btn-primary btn-lg px-4 py-3" style="border-radius: 25px; font-weight: 600; box-shadow: 0 5px 15px rgba(0,123,255,0.3);">
                                    <i class="fas fa-chart-bar me-2"></i>Lihat Nilai Lengkap
                                </a>
                                <a href="{{ route('tryout.pembahasan', $ujianUser->ujian_id) }}" class="btn btn-success btn-lg px-4 py-3" style="border-radius: 25px; font-weight: 600; box-shadow: 0 5px 15px rgba(40,167,69,0.3);">
                                    <i class="fas fa-book-open me-2"></i>Lihat Pembahasan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
<style>
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
    .detail-header h1 {
        font-size: 2rem !important;
    }
    
    .stat-card {
        margin-bottom: 15px;
    }
    
    .score-display div:last-child {
        font-size: 2rem !important;
    }
}
</style>
@endpush