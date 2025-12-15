@extends('layouts/admin/app')

@section('title')
Data Artikel
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Artikel</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.article.create') }}" class="btn btn-outline-success">
                        <i class="fa fa-plus-circle"></i> Tambah Artikel
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <table class="table table-bordered table-striped" id="article-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 80px">Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Featured</th>
                                <th>Views</th>
                                <th>Tanggal Publish</th>
                                <th style="width: 15%"><i class="fa fa-cog"></i></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('#article-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('admin.article.data') }}'
            },
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'image', searchable: false, orderable: false },
                { data: 'title' },
                { data: 'category' },
                { data: 'author' },
                { data: 'status' },
                { data: 'is_featured' },
                { data: 'views' },
                { data: 'published_at' },
                { data: 'action', searchable: false, orderable: false }
            ],
            dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            columnDefs: [
                { className: 'text-center', targets: [0, 1, 5, 6, 7, 8, 9] }
            ]
        });
    });
</script>
@endpush