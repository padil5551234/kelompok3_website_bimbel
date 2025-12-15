@extends('layouts.admin.app')

@section('title', 'Detail Kelas Live')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('tutor.live-classes.index') }}">Kelas Live</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-video"></i> {{ $liveClass->title }}</h4>
                    <div class="card-header-action">
                        @if($liveClass->status == 'scheduled')
                            <form action="{{ route('tutor.live-classes.start', $liveClass) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-play"></i> Mulai Kelas
                                </button>
                            </form>
                            <a href="{{ route('tutor.live-classes.edit', $liveClass) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @elseif($liveClass->status == 'ongoing')
                            <form action="{{ route('tutor.live-classes.end', $liveClass) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm">
                                    <i class="fas fa-stop"></i> Akhiri Kelas
                                </button>
                            </form>
                        @endif
                        
                        @if(in_array($liveClass->status, ['scheduled', 'ongoing']))
                            <form action="{{ route('tutor.live-classes.cancel', $liveClass) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin membatalkan kelas ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-info-circle"></i> Status:</strong><br>
                                @if($liveClass->status == 'scheduled')
                                    <span class="badge badge-warning badge-lg">Terjadwal</span>
                                @elseif($liveClass->status == 'ongoing')
                                    <span class="badge badge-success badge-lg">Berlangsung</span>
                                @elseif($liveClass->status == 'completed')
                                    <span class="badge badge-info badge-lg">Selesai</span>
                                @else
                                    <span class="badge badge-danger badge-lg">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-laptop"></i> Platform:</strong><br>
                                <span class="badge badge-info badge-lg">{{ ucfirst(str_replace('_', ' ', $liveClass->platform)) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-calendar"></i> Tanggal & Waktu:</strong><br>
                                {{ \Carbon\Carbon::parse($liveClass->scheduled_at)->format('d F Y, H:i') }} WIB
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-clock"></i> Durasi:</strong><br>
                                {{ $liveClass->duration_minutes }} menit
                            </div>
                        </div>
                    </div>

                    @if($liveClass->description)
                    <div class="mb-3">
                        <strong><i class="fas fa-align-left"></i> Deskripsi:</strong><br>
                        <p class="text-muted">{{ $liveClass->description }}</p>
                    </div>
                    @endif

                    @if($liveClass->meeting_link)
                    <div class="mb-3">
                        <strong><i class="fas fa-link"></i> Link Meeting:</strong><br>
                        <a href="{{ $liveClass->meeting_link }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-external-link-alt"></i> Buka Meeting
                        </a>
                        <code class="ml-2">{{ $liveClass->meeting_link }}</code>
                    </div>
                    @endif

                    @if($liveClass->meeting_password)
                    <div class="mb-3">
                        <strong><i class="fas fa-key"></i> Password Meeting:</strong><br>
                        <code>{{ $liveClass->meeting_password }}</code>
                    </div>
                    @endif

                    @if($liveClass->max_participants)
                    <div class="mb-3">
                        <strong><i class="fas fa-users"></i> Maksimal Peserta:</strong><br>
                        {{ $liveClass->max_participants }} orang
                    </div>
                    @endif

                    @if($liveClass->materials && is_array($liveClass->materials) && count($liveClass->materials) > 0)
                    <div class="mb-3">
                        <strong><i class="fas fa-book"></i> Materi Pembelajaran:</strong>
                        <ul class="mt-2">
                            @foreach($liveClass->materials as $material)
                                <li>{{ $material }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <strong><i class="fas fa-user"></i> Tutor:</strong><br>
                        {{ $liveClass->tutor->name }}
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-clock"></i> Dibuat:</strong><br>
                        {{ \Carbon\Carbon::parse($liveClass->created_at)->format('d F Y, H:i') }}
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('tutor.live-classes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    @if($liveClass->meeting_link && in_array($liveClass->status, ['scheduled', 'ongoing']))
                        <a href="{{ $liveClass->meeting_link }}" target="_blank" class="btn btn-primary float-right">
                            <i class="fas fa-video"></i> Join Meeting
                        </a>
                    @endif
                </div>
            </div>

            @if($liveClass->status == 'scheduled')
            <div class="card mt-3">
                <div class="card-header">
                    <h4><i class="fas fa-bell"></i> Reminder</h4>
                </div>
                <div class="card-body">
                    <p class="mb-0">
                        <i class="fas fa-info-circle text-info"></i> 
                        Jangan lupa untuk mempersiapkan materi dan memastikan link meeting sudah aktif sebelum kelas dimulai.
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.badge-lg {
    font-size: 14px;
    padding: 8px 12px;
}
</style>
@endpush