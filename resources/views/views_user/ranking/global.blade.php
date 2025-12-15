@extends('layouts.user.app')

@section('title')
    Peringkat Global Tryout
@endsection

@section('content')
    <main id="main">
        <div class="container mb-4" style="margin-top: 124px">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title"><b>Peringkat Global Tryout Saya</b></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h4>Total Skor</h4>
                                            <h2>{{ $totalScore }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h4>Tryout Diselesaikan</h4>
                                            <h2>{{ $totalExams }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info text-white">
                                        <div class="card-body text-center">
                                            <h4>Rata-rata Skor</h4>
                                            <h2>{{ $totalExams > 0 ? round($totalScore / $totalExams, 1) : 0 }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('progres.nilai') }}" class="btn btn-light">
                                    <i class="fas fa-chart-line"></i> Lihat Grafik Progres Lengkap
                                </a>
                            </div>
                        </div>
                    </div>


                    @if($completedExams->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><b>Detail Peringkat per Tryout</b></h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nama Tryout</th>
                                                <th>Jenis Ujian</th>
                                                <th>Skor Anda</th>
                                                <th>Peringkat</th>
                                                <th>Total Peserta</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($examRankings as $ranking)
                                                <tr>
                                                    <td>{{ $ranking['exam']->nama }}</td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ strtoupper($ranking['exam']->jenis_ujian) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $ranking['score'] }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">{{ $ranking['rank'] }}</span>
                                                    </td>
                                                    <td>{{ $ranking['total_participants'] }}</td>
                                                    <td>
                                                        <a href="{{ route('tryout.nilai', $ranking['exam']->id) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-chart-bar"></i> Lihat Detail
                                                        </a>
                                                        <a href="{{ route('tryout.pembahasan', $ranking['exam']->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-book-open"></i> Pembahasan
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body text-center">
                                <h4>Belum ada tryout yang diselesaikan</h4>
                                <p>Selesaikan tryout terlebih dahulu untuk melihat peringkat global Anda.</p>
                                <a href="{{ route('tryout.index') }}" class="btn btn-primary">
                                    <i class="fas fa-play"></i> Mulai Tryout
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
