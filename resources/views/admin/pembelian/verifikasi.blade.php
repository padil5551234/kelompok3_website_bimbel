@extends('layouts.admin.app')

@section('title')
    Verifikasi Pembayaran Manual
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.css') }}" type="text/css">
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Verifikasi Pembayaran Manual</h6>
                        <div>
                            <span class="badge bg-info" id="pending-count">0 pending</span>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table align-items-center mb-0" id="table-verifikasi">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Paket</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Upload</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bukti</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lihat Bukti -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Detail Pembayaran:</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Nama</strong></td>
                                    <td id="detail-user"></td>
                                </tr>
                                <tr>
                                    <td><strong>Email</strong></td>
                                    <td id="detail-email"></td>
                                </tr>
                                <tr>
                                    <td><strong>Paket</strong></td>
                                    <td id="detail-paket"></td>
                                </tr>
                                <tr>
                                    <td><strong>Harga</strong></td>
                                    <td id="detail-harga"></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal Upload</strong></td>
                                    <td id="detail-tanggal"></td>
                                </tr>
                            </table>
                            
                            <div class="mt-3">
                                <h6>Catatan Pembayaran:</h6>
                                <p id="detail-catatan" class="text-sm"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Bukti Transfer:</h6>
                            <img id="bukti-image" src="" alt="Bukti Transfer" class="img-fluid" style="cursor: pointer;" onclick="window.open(this.src, '_blank')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="verifikasiForm">
                    @csrf
                    <input type="hidden" id="verifikasi-id" name="id">
                    <input type="hidden" id="verifikasi-action" name="action">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="catatan_admin" class="form-label">Catatan Admin (Opsional)</label>
                            <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="3" 
                                placeholder="Masukkan catatan jika diperlukan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnVerifikasi">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Initialize DataTable
            var table = $('#table-verifikasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.pembelian.verifikasi.data') }}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'nama', name: 'nama'},
                    {data: 'email', name: 'email'},
                    {data: 'paket', name: 'paket'},
                    {data: 'harga', name: 'harga'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'bukti', name: 'bukti', orderable: false, searchable: false},
                    {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    $('#pending-count').text(api.page.info().recordsTotal + ' pending');
                }
            });

            // Auto refresh every 30 seconds
            setInterval(function() {
                table.ajax.reload(null, false);
            }, 30000);
        });

        // Function to show bukti transfer
        function lihatBukti(url) {
            $.get(url, function(data) {
                $('#detail-user').text(data.user);
                $('#detail-email').text(data.email);
                $('#detail-paket').text(data.paket);
                $('#detail-harga').text(data.harga);
                $('#detail-tanggal').text(data.tanggal_upload);
                $('#detail-catatan').text(data.catatan_pembayaran || 'Tidak ada catatan');
                $('#bukti-image').attr('src', data.bukti_transfer);
                
                var buktiModal = new bootstrap.Modal(document.getElementById('buktiModal'));
                buktiModal.show();
            }).fail(function() {
                toastr.error('Gagal memuat data');
            });
        }

        // Function to show verifikasi modal
        function verifikasiPembayaran(id, action) {
            $('#verifikasi-id').val(id);
            $('#verifikasi-action').val(action);
            $('#catatan_admin').val('');
            
            if (action === 'approve') {
                $('#verifikasiModalLabel').text('Approve Pembayaran');
                $('#btnVerifikasi').removeClass('btn-danger').addClass('btn-success').text('Approve');
            } else {
                $('#verifikasiModalLabel').text('Reject Pembayaran');
                $('#btnVerifikasi').removeClass('btn-success').addClass('btn-danger').text('Reject');
                $('#catatan_admin').attr('placeholder', 'Alasan penolakan (wajib diisi untuk reject)');
            }
            
            var verifikasiModal = new bootstrap.Modal(document.getElementById('verifikasiModal'));
            verifikasiModal.show();
        }

        // Handle verifikasi form submit
        $('#verifikasiForm').on('submit', function(e) {
            e.preventDefault();
            
            const id = $('#verifikasi-id').val();
            const action = $('#verifikasi-action').val();
            const catatan = $('#catatan_admin').val();
            
            // Validate catatan for reject action
            if (action === 'reject' && !catatan) {
                toastr.error('Alasan penolakan wajib diisi');
                return;
            }
            
            const btnVerifikasi = $('#btnVerifikasi');
            const originalText = btnVerifikasi.text();
            btnVerifikasi.prop('disabled', true).text('Processing...');
            
            $.ajax({
                url: `/admin/pembelian/${id}/proses-verifikasi`,
                type: 'POST',
                data: {
                    action: action,
                    catatan_admin: catatan
                },
                success: function(response) {
                    toastr.success(response.message);
                    bootstrap.Modal.getInstance(document.getElementById('verifikasiModal')).hide();
                    $('#table-verifikasi').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan';
                    toastr.error(errorMsg);
                },
                complete: function() {
                    btnVerifikasi.prop('disabled', false).text(originalText);
                }
            });
        });
    </script>
@endpush