@extends('layouts/admin/app')

@section('title')
Data Testimonial
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Testimonial</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a type="button" href="{{ route('admin.testimonial.create') }}" class="btn btn-outline-success"><i class="fa fa-plus-circle"></i> Tambah Testimonial</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="" method="post" class="form-member">
                        @csrf
                        <table class="table table-bordered table-striped center-header" id="Table-Testimonial">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama</th>
                                    <th>Lulusan</th>
                                    <th>Pesan</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th style="width: 15%"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                    <!-- /.row -->
                </div>
                <!-- ./card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
</div>

@endsection

@push('scripts')
<script>
    @if(Session::has('success'))
        toastr.options =
        {
            "positionClass": "toast-bottom-right",
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('success') }}");
    @endif

    let tableTestimonial;
    $(function() {
        tableTestimonial = $('#Table-Testimonial').DataTable({
            processing: true
            , responsive: true
            , autoWidth: false
            , ajax: {
                url: '{{ route('admin.testimonial.data') }}'
            , }
            , columns: [
                {
                    data: 'DT_RowIndex'
                    , searchable: false
                    , sortable: false
                },
                { data: 'name'},
                { data: 'graduation'},
                { data: 'message'},
                { data: 'rating_display'},
                { data: 'status'},
                {
                    data: 'aksi'
                    , searchable: false
                    , sortable: false
                }
            , ]
            , dom: '<"container-fluid"<"row"<"col"B><"col"l><"col"f>>>rtip'
            , buttons: [
                'copy', 'excel', 'pdf'
            ]
            , columnDefs: [
                { className: 'text-center', targets: [0, 4, 5, 6] },
            ]
        });
    });

    function editForm(url) {
        window.location.href = url;
    }

    function deleteData(url) {
        Swal.fire({
            title: 'Apakah kamu yakin akan menghapus testimonial?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
            }).then((result) => {
            if (result.isConfirmed) {
                $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    tableTestimonial.ajax.reload();
                    toastr.success('Testimonial berhasil dihapus.');
                    toastr.options = {"positionClass": "toast-bottom-right"};
                })
                .fail((response) => {
                    toastr.error('Tidak dapat menghapus testimonial.');
                    return;
                })
            }
        })
    }
</script>
@endpush