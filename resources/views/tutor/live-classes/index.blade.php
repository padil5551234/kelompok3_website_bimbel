@extends('layouts.admin.app')

@section('title', 'Kelola Kelas Live')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kelas Live</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Kelola Kelas Live</h4>
                    <div class="card-header-action">
                        <a href="{{ route('tutor.live-classes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Kelas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form method="GET" action="{{ route('tutor.live-classes.index') }}">
                                <div class="input-group">
                                    <select name="status" class="form-control" onchange="this.form.submit()">
                                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                        <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <form method="GET" action="{{ route('tutor.live-classes.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari kelas..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($liveClasses->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-video fa-4x text-secondary mb-3"></i>
                            <h5>Belum ada kelas live</h5>
                            <p class="text-muted">Mulai dengan membuat kelas live pertama Anda</p>
                            <a href="{{ route('tutor.live-classes.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus"></i> Buat Kelas Live
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Platform</th>
                                        <th>Jadwal</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($liveClasses as $class)
                                    <tr>
                                        <td>
                                            <strong>{{ $class->title }}</strong>
                                            @if($class->description)
                                                <br><small class="text-muted">{{ Str::limit($class->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($class->platform) }}</span>
                                        </td>
                                        <td>
                                            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($class->scheduled_at)->format('d M Y') }}<br>
                                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($class->scheduled_at)->format('H:i') }}
                                        </td>
                                        <td>{{ $class->duration_minutes }} menit</td>
                                        <td>
                                            @if($class->status == 'scheduled')
                                                <span class="badge badge-warning">Terjadwal</span>
                                            @elseif($class->status == 'ongoing')
                                                <span class="badge badge-success">Berlangsung</span>
                                            @elseif($class->status == 'completed')
                                                <span class="badge badge-info">Selesai</span>
                                            @else
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tutor.live-classes.show', $class) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($class->status == 'scheduled')
                                                <a href="{{ route('tutor.live-classes.edit', $class) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('tutor.live-classes.destroy', $class) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $liveClasses->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection