@extends('layouts.user.app')

@section('title')
    {{ $pembelian->paketUjian->nama }}
@endsection

@section('content')
    <main id="main">
        <div class="container" style="margin-top: 124px">
            <div class="row" style="justify-content:center">
                <div class="col-lg-6 col-md-8 mx-auto">
                    @if ($pembelian->status == 'Sukses')
                        <div class="success-notification animate__animated animate__fadeInDown">
                            <div class="success-header">
                                <div class="success-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="success-content">
                                    <h4 class="success-title">🎉 Pembayaran Berhasil!</h4>
                                    <p class="success-message">Terima kasih telah melakukan pembayaran untuk paket <strong>{{ $pembelian->paketUjian->nama }}</strong></p>
                                    @if($pembelian->paketUjian->whatsapp_group_link)
                                        <div class="whatsapp-info">
                                            <i class="fab fa-whatsapp"></i>
                                            <span>Silakan bergabung ke grup WhatsApp melalui tombol di bawah untuk mendapatkan info terbaru!</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="success-footer">
                                <div class="confetti">
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                    <div class="confetti-piece"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Transaksi <b>#{{ sprintf('%06d', $pembelian->id) }}</b></h6>
                        </div>
                        <div id="transaction" class="card-body px-3 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                    <tr>
                                        <td style="text-align: right; width: 50%">
                                            <h6 class="mb-0 mr-6">Nama Paket Ujian</h6>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">{{ $pembelian->paketUjian->nama }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">
                                            <h6 class="mb-0 mr-6">Email</h6>
                                        </td>
                                        <td>
                                            <p class="font-weight-bold mb-0">{{ auth()->user()->email }}</p>
                                        </td>
                                    </tr>
                                    <td style="text-align: right">
                                        <h6 class="mb-0 mr-6">Tanggal Pembelian</h6>
                                    </td>
                                    <td>
                                        <p class="font-weight-bold mb-0">{{ \Carbon\Carbon::parse($pembelian->created_at)->isoFormat('D MMMM Y HH:mm:ss') }}</p>
                                    </td>
                                    </tr>
                                    </tr>
                                    <td style="text-align: right">
                                        <h6 class="mb-0 mr-6">Harga</h6>
                                    </td>
                                    <td id="harga">
                                        <p class="font-weight-bold mb-0">
                                        Rp{{ number_format( $pembelian->harga , 0 , ',' , '.' ) }}
                                        @if($pembelian->id_voucher)
                                            <br><small class="text-success">Diskon: Rp{{ number_format($pembelian->voucher->diskon, 0, ',', '.') }}</small>
                                        @endif
                                    </p>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">
                                            <h6 class="mb-0 mr-6">Status</h6>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $pembelian->status == 'Sukses' ? 'success' : ($pembelian->status == 'Pending' ? 'warning' : ($pembelian->status == 'Belum dibayar' ? 'primary' : 'danger')) }}">{{ $pembelian->status }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">
                                            <h6 class="mt-2 mr-6">Voucher</h6>
                                        </td>
                                        @if($pembelian->status == 'Sukses')
                                            <td>
                                                <span
                                                    class="badge badge-primary">{{ $pembelian->voucher ? 'Rp' . number_format($pembelian->voucher->diskon, 0 , ',' , '.') : '' }}</span>
                                            </td>
                                        @else
                                            <form method="post" id="applyVoucher"
                                                  action="{{ route('pembelian.applyVoucher') }}">
                                                @csrf
                                                @method('post')
                                                <td>
                                                    <div class="row">
                                                        <div class="col-lg-9">
                                                            <input type="hidden" required name="id"
                                                                    value="{{ $pembelian->id }}">
                                                             <input type="text"
                                                                    @if($pembelian->id_voucher) @readonly(true) value="{{ $pembelian->voucher->kode }}"
                                                                    @endif class="form-control" id="voucher"
                                                                    name="voucher" val
                                                                    placeholder="Masukkan voucher disini">
                                                        </div>
                                                        @if($pembelian->status == 'Belum dibayar')
                                                            <div class="col-lg-3">
                                                                <button id="apply" type="submit" class="btn btn-{{ $pembelian->id_voucher ? 'danger' : 'primary' }}">
                                                                    {!! $pembelian->id_voucher ? '&#x2716;' : '&#x2713;' !!}
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div id="deskripsi">
                                                        @if($pembelian->id_voucher)
                                                            @if($pembelian->voucher->diskon > 0)
                                                                <span style="color: green; font-size: 12px">Anda mendapatkan diskon Rp{{ number_format( $pembelian->voucher->diskon , 0 , ',' , '.' ) }}</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </form>
                                        @endif

                                    </tr>
                                    <tr>
                                        <td style="text-align: right">
                                            <h6 class="mb-0 mr-6">Metode Pembayaran</h6>
                                        </td>
                                        <td>
                                            @if($pembelian->status != 'Sukses' && $pembelian->status != 'Menunggu Verifikasi')
                                                <div class="form-check payment-method">
                                                    <input class="form-check-input" type="radio"
                                                           name="metode_pembayaran" id="metode_pembayaran3"
                                                           value="manual-transfer" checked>
                                                    <label class="form-check-label" for="metode_pembayaran3">
                                                        <i class="fas fa-upload text-primary me-2"></i>
                                                        <strong>Transfer Manual</strong> (Upload Bukti)
                                                    </label>
                                                </div>
                                                <div class="form-check payment-method">
                                                    <input class="form-check-input" type="radio"
                                                           name="metode_pembayaran" id="metode_pembayaran2"
                                                           value="bank-transfer">
                                                    <label class="form-check-label" for="metode_pembayaran2">
                                                        <i class="fas fa-university text-primary me-2"></i>
                                                        <strong>Transfer Bank Otomatis</strong> (+ Admin 4500)
                                                    </label>
                                                </div>
                                            @else
                                                <p class="font-weight-bold mb-0">{{ $pembelian->jenis_pembayaran ?? 'Transfer Manual' }}</p>
                                            @endif
                                        </td>
                                    </tr>
                                    
                                    @if($pembelian->status == 'Menunggu Verifikasi')
                                    <tr>
                                        <td style="text-align: right">
                                            <h6 class="mb-0 mr-6">Status Verifikasi</h6>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Menunggu Verifikasi Admin</span>
                                            <p class="text-sm mt-2">Bukti transfer Anda sedang diverifikasi oleh admin.</p>
                                        </td>
                                    </tr>
                                    @if($pembelian->bukti_transfer)
                                    <tr>
                                        <td style="text-align: right">
                                            <h6 class="mb-0 mr-6">Bukti Transfer</h6>
                                        </td>
                                        <td>
                                            <img src="{{ asset('storage/bukti_transfer/' . $pembelian->bukti_transfer) }}"
                                                 alt="Bukti Transfer" class="img-fluid" style="max-width: 300px; cursor: pointer;"
                                                 onclick="window.open(this.src, '_blank')">
                                        </td>
                                    </tr>
                                    @endif
                                    @endif
                                    <tr>
                                        <td></td>
                                        <td style="text-align:right;">
                                            @if($pembelian->status == 'Gagal')
                                                <form method="post" action="{{ route('pembelian.store') }}">
                                                    @csrf
                                                    @method('post')
                                                    <input type="hidden" name="paket_id"
                                                           value="{{ $pembelian->paket_id }}">
                                                    <button type="submit" class="btn btn-warning mt-4 mb-0">Ulangi
                                                        Bayar
                                                    </button>
                                                </form>
                                            @elseif($pembelian->status == 'Sukses')
                                                @if($pembelian->paketUjian->whatsapp_group_link)
                                                    <a target="_blank"
                                                       href="{{ $pembelian->paketUjian->whatsapp_group_link }}"
                                                       type="button" class="btn btn-success mt-4 mb-0">
                                                        <i class="fab fa-whatsapp"></i> Gabung Grup WhatsApp
                                                    </a>
                                                @endif
                                                <a href="{{ route('tryout.index', $pembelian->paket_id) }}"
                                                   type="button" class="btn btn-primary mt-4 mb-0">
                                                    <i class="fas fa-play-circle"></i> Mulai Tryout
                                                </a>
                                            @elseif($pembelian->status == 'Menunggu Verifikasi')
                                                @if($pembelian->whatsapp_admin)
                                                    <a target="_blank"
                                                       href="https://wa.me/{{ $pembelian->whatsapp_admin }}?text=Halo admin, saya sudah upload bukti transfer untuk transaksi %23{{ sprintf('%06d', $pembelian->id) }}"
                                                       type="button" class="btn btn-success mt-4 mb-0">
                                                        <i class="fab fa-whatsapp"></i> Chat Admin
                                                    </a>
                                                @endif
                                            @else
                                                <button type="button" id="btnProceed" onClick="proceedPayment()" class="btn btn-success mt-4 mb-0">
                                                    Lanjutkan
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Upload Bukti Transfer -->
    <div class="modal fade" id="uploadBuktiModal" tabindex="-1" aria-labelledby="uploadBuktiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadBuktiModalLabel">Upload Bukti Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="uploadBuktiForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi Rekening Transfer:</h6>
                            <p class="mb-1"><strong>Bank:</strong> BCA / Mandiri / BNI</p>
                            <p class="mb-1"><strong>No. Rekening:</strong> 1234567890</p>
                            <p class="mb-1"><strong>Atas Nama:</strong> PT Bimbel Indonesia</p>
                            <p class="mb-0"><strong>Jumlah:</strong> Rp{{ number_format($pembelian->harga, 0, ',', '.') }}</p>
                        </div>
                        
                        <input type="hidden" name="id" value="{{ $pembelian->id }}">
                        
                        <div class="mb-3">
                            <label for="bukti_transfer" class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="catatan_pembayaran" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="catatan_pembayaran" name="catatan_pembayaran" rows="3"
                                placeholder="Contoh: Transfer dari rekening atas nama John Doe"></textarea>
                        </div>
                        
                        <div id="preview-container" class="mb-3" style="display:none;">
                            <label class="form-label">Preview:</label>
                            <img id="preview-image" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnUpload">
                            <i class="fas fa-upload"></i> Upload Bukti
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($pembelian->status != 'Gagal')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const payButton = document.querySelector('#pay');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            // Preview image before upload
            $('#bukti_transfer').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result);
                        $('#preview-container').show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Handle proceed payment button
            function proceedPayment() {
                const metode = document.querySelector('input[name="metode_pembayaran"]:checked').value;

                if (metode === 'manual-transfer') {
                    // Show upload modal for manual transfer
                    var uploadModal = new bootstrap.Modal(document.getElementById('uploadBuktiModal'));
                    uploadModal.show();
                } else {
                    // Process with Midtrans for automatic payment
                    pay();
                }
            }

            // Handle upload bukti transfer
            $('#uploadBuktiForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const btnUpload = $('#btnUpload');
                const originalText = btnUpload.html();
                
                btnUpload.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
                
                $.ajax({
                    url: '{{ route('pembelian.upload-bukti') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.options = {"positionClass": "toast-bottom-right"};
                        toastr.success(response.message);
                        
                        // Show WhatsApp link if available
                        if (response.whatsapp_admin) {
                            setTimeout(function() {
                                const whatsappUrl = `https://wa.me/${response.whatsapp_admin}?text=Halo admin, saya sudah upload bukti transfer untuk transaksi %23{{ sprintf('%06d', $pembelian->id) }}`;
                                if (confirm('Bukti transfer berhasil diupload! Klik OK untuk chat admin via WhatsApp.')) {
                                    window.open(whatsappUrl, '_blank');
                                }
                                location.reload();
                            }, 1500);
                        } else {
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        }
                    },
                    error: function(xhr) {
                        toastr.options = {"positionClass": "toast-bottom-right"};
                        const errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan saat upload';
                        toastr.error(errorMsg);
                        btnUpload.prop('disabled', false).html(originalText);
                    }
                });
            });

            function pay() {
                $.post('{{ route('pembelian.pay') }}',
                    {
                        "_token": "{{ csrf_token() }}",
                        _method: 'post',
                        id: '{{ $pembelian->id }}',
                        metode: document.querySelector('input[name="metode_pembayaran"]:checked').value,
                    })
                    .done((response) => {
                        console.log(response);
                        @if (env("MIDTRANS_TIPE") == 'production')
                            window.location.href = `https://app.midtrans.com/snap/v3/redirection/${response.snapToken}#/${response.metode}`;
                        @else
                            window.location.href = `https://app.sandbox.midtrans.com/snap/v3/redirection/${response.snapToken}#/${response.metode}`;
                        @endif
                    })
                    .fail((response) => {
                        toastr.options = {"positionClass": "toast-bottom-right"};
                        toastr.error('Tidak dapat membayar, silahkan hubungi admin.');
                        return;
                    })
            }

            $(function () {
                $('#applyVoucher').on('submit', function (e) {
                    e.preventDefault();
                    $.post($('#applyVoucher').attr('action'), $('#applyVoucher').serialize())
                        .done((response) => {
                            toastr.options = {"positionClass": "toast-bottom-right"};
                            toastr.success(response.message);

                            // Update harga secara real-time jika ada response harga_baru
                            if (response.harga_baru !== undefined) {
                                $('#harga p').html('Rp' + new Intl.NumberFormat('id-ID').format(response.harga_baru));
                                if (response.diskon > 0) {
                                    $('#harga p').append('<br><small class="text-success">Diskon: Rp' + new Intl.NumberFormat('id-ID').format(response.diskon) + '</small>');
                                }
                            }

                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                        })
                        .fail((response) => {
                            toastr.options = {"positionClass": "toast-bottom-right"};
                            toastr.error(response.responseJSON.message);
                            setTimeout(function () {
                                location.reload();
                            }, 1500);
                            return;
                        });
                })
            })
        </script>
    @endif
@endpush
