<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Voucher;
use App\Models\Pembelian;
use App\Models\PaketUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Services\Midtrans\CreateSnapTokenService;
use App\Mail\PembelianSukses;
use App\Mail\PembelianGagal;
use App\Mail\PembelianPendingVerifikasi;
use App\Mail\PembelianTerverifikasi;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = explode('-', request()->order_id);
        $order_id = $id[0];
        return redirect()->route('pembelian.show', $order_id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    function beliPaket($paket_id)
    {
        $cek = Pembelian::where('user_id', auth()->user()->id)
            ->where('paket_id', $paket_id)
            ->latest('updated_at')
            ->first();
        $paketUjian = PaketUjian::find($paket_id);

        if (
            !Carbon::now()->between(
                $paketUjian->waktu_mulai,
                $paketUjian->waktu_akhir
            )
        ) {
            abort(403, 'Waktu pendaftaran sudah selesai');
        }

        if (!$cek) {
            $pembelian = new Pembelian();
            $pembelian->paket_id = $paket_id;
            $pembelian->user_id = auth()->user()->id;
            $pembelian->status =
                $paketUjian->harga == 0 ? 'Sukses' : 'Belum dibayar';
            $pembelian->harga = $paketUjian->harga;

            $pembelian->save();
            $id_pembelian = $pembelian->id;
            
            // Auto-verify email for free packages
            if ($paketUjian->harga == 0) {
                $user = auth()->user();
                if ($user && !$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }
            }
        } else {
            if ($cek->status == 'Gagal') {
                $pembelian = new Pembelian();
                $pembelian->paket_id = $paket_id;
                $pembelian->user_id = auth()->user()->id;
                $pembelian->status =
                    $paketUjian->harga == 0 ? 'Sukses' : 'Belum dibayar';
                $pembelian->harga = $paketUjian->harga;

                $pembelian->save();

                $id_pembelian = $pembelian->id;
                
                // Auto-verify email for free packages
                if ($paketUjian->harga == 0) {
                    $user = auth()->user();
                    if ($user && !$user->hasVerifiedEmail()) {
                        $user->markEmailAsVerified();
                    }
                }
            } else {
                $id_pembelian = $cek->id;
            }
        }

        // Skip profile check for tutors or in testing mode
        if (!auth()->user()->hasRole('tutor') && !env('TESTING_MODE', false)) {
            $check = false;
            $user = \App\Models\User::with([
                'usersDetail' => function ($query) {
                    $query
                        ->where('no_hp', '!=', null)
                        ->where('sumber_informasi', '!=', null)
                        ->where('prodi', '!=', null)
                        ->where('penempatan', '!=', null);
                },
            ])
                ->where('id', auth()->user()->id)
                ->first();
            if ($user->usersDetail) {
                $check = true;
            }

            if (!$check) {
                return redirect()
                    ->route('profile.show')
                    ->with([
                        'message' => 'Silahkan lengkapi profil terlebih dahulu.',
                        'id_pembelian' => $id_pembelian,
                    ]);
            }
        }

        return redirect()->route('pembelian.show', $id_pembelian);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->beliPaket($request->paket_id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pembelian = Pembelian::with(
            'paketUjian',
            'user',
            'voucher'
        )->findOrFail($id);
        if (
            !Carbon::now()->between(
                $pembelian->paketUjian->waktu_mulai,
                $pembelian->paketUjian->waktu_akhir
            )
        ) {
            abort(403, 'Waktu pendaftaran sudah selesai');
        }

        if ($pembelian->user_id === auth()->user()->id) {
            return view('views_user.pembelian.index', compact('pembelian'));
        }
        abort(403, 'Error');
    }

    public function applyVoucher(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id);
        if (!$pembelian) {
            return response()->json(['message' => 'Invalid.'], 400);
        }

        if ($pembelian->id_voucher == null) {
            $voucher = Voucher::where('kode', $request->voucher)
                ->where('paket_ujian_id', $pembelian->paket_id)
                ->first();
            if (!$voucher) {
                return response()->json(['message' => 'Kode voucher tidak valid atau tidak sesuai dengan paket ujian.'], 400);
            }
            if ($voucher->kuota > 0) {
                // Hitung harga setelah diskon, pastikan tidak negatif
                $hargaAsli = $pembelian->paketUjian->harga;
                $hargaSetelahDiskon = max(0, $hargaAsli - $voucher->diskon);

                $voucher->kuota = $voucher->kuota - 1;
                $voucher->update();
                $pembelian->id_voucher = $voucher->id;
                $pembelian->harga = $hargaSetelahDiskon;
                $pembelian->update();

                return response()->json([
                    'message' => 'Voucher berhasil digunakan! Diskon Rp' . number_format($voucher->diskon, 0, ',', '.') . ' telah diterapkan.',
                    'harga_baru' => $hargaSetelahDiskon,
                    'diskon' => $voucher->diskon
                ], 200);
            } else {
                return response()->json(['message' => 'Maaf, kuota voucher sudah habis.'], 400);
            }
        } else {
            $voucher = Voucher::findOrFail($pembelian->id_voucher);
            // Kembalikan ke harga asli paket
            $hargaAsli = $pembelian->paketUjian->harga;
            $pembelian->id_voucher = null;
            $pembelian->harga = $hargaAsli;
            $pembelian->update();

            $voucher->kuota = $voucher->kuota + 1;
            $voucher->update();

            return response()->json([
                'message' => 'Voucher berhasil dibatalkan.',
                'harga_baru' => $hargaAsli,
                'diskon' => 0
            ], 200);
        }

        return response()->json(['message' => 'Terjadi kesalahan. Silakan coba lagi.'], 400);
    }

    public function pay(Request $request)
    {
        try {
            $pembelian = Pembelian::findOrFail($request->id);
            $snapToken = $pembelian->kode_pembelian;
            $total = 0;
            $item_details[] = [
                'id' => $pembelian->paketUjian->id,
                'price' => $pembelian->harga,
                'quantity' => 1,
                'name' => $pembelian->paketUjian->nama,
            ];
            $total += $pembelian->harga;

            if ($request->metode == 'bank-transfer') {
                $item_details[] = [
                    'id' => 999999,
                    'price' => 4500,
                    'quantity' => 1,
                    'name' => 'Biaya admin',
                ];
                $total += 4500;
            }

            $midtrans = new CreateSnapTokenService(
                $pembelian,
                $request->metode,
                $item_details,
                $total
            );
            $snapToken = $midtrans->getSnapToken($request->metode_pembayaran);

            if (is_null($snapToken) || empty($snapToken)) {
                return response()->json(
                    'Tidak dapat membayar, silahkan hubungi admin.',
                    400
                );
            }

            $pembelian->kode_pembelian = $snapToken;
            $pembelian->update();

            return response()->json(
                [
                    'snapToken' => $snapToken,
                    'metode' => $request->metode,
                ],
                200
            );
        } catch (\Exception $e) {
            \Log::error('Payment error: ' . $e->getMessage());
            return response()->json(
                'Tidak dapat membayar, silahkan hubungi admin.',
                400
            );
        }
    }

    /**
     * Upload bukti transfer untuk pembayaran manual
     */
    public function uploadBuktiTransfer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:pembelian,id',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan_pembayaran' => 'nullable|string|max:500',
        ], [
            'bukti_transfer.required' => 'Bukti transfer wajib diupload',
            'bukti_transfer.image' => 'File harus berupa gambar',
            'bukti_transfer.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'bukti_transfer.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $pembelian = Pembelian::findOrFail($request->id);

        // Cek apakah user adalah pemilik pembelian
        if ($pembelian->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Upload file bukti transfer
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = 'bukti_' . $pembelian->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/bukti_transfer', $filename);

            // Hapus file lama jika ada
            if ($pembelian->bukti_transfer && \Storage::exists('public/bukti_transfer/' . $pembelian->bukti_transfer)) {
                \Storage::delete('public/bukti_transfer/' . $pembelian->bukti_transfer);
            }

            $pembelian->bukti_transfer = $filename;
        }

        $pembelian->catatan_pembayaran = $request->catatan_pembayaran;
        $pembelian->status_verifikasi = 'pending';
        $pembelian->status = 'Menunggu Verifikasi';
        
        // Set nomor WhatsApp admin
        $pembelian->whatsapp_admin = env('WHATSAPP_ADMIN', '6281234567890');
        
        $pembelian->save();

        // Send pending verification email notification
        try {
            Mail::to($pembelian->user->email)->send(new PembelianPendingVerifikasi($pembelian));
        } catch (\Exception $e) {
            // Log error but don't fail the upload
            \Log::error('Failed to send pending verification email: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Bukti transfer berhasil diupload. Silakan hubungi admin untuk verifikasi.',
            'whatsapp_admin' => $pembelian->whatsapp_admin
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembelian $pembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelian $pembelian)
    {
        //
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        $id = explode('-', $request->order_id);
        $order_id = $id[0];
        if ($hashed == $request->signature_key) {
            if (
                $request->transaction_status == 'capture' ||
                $request->transaction_status == 'settlement'
            ) {
                $pembelian = Pembelian::find($order_id);
                $pembelian->status = 'Sukses';
                $pembelian->jenis_pembayaran = $request->payment_type;
                // Log QRIS payment success for debugging
                if ($request->payment_type == 'qris') {
                    \Log::info('QRIS payment successful', [
                        'order_id' => $request->order_id,
                        'transaction_status' => $request->transaction_status,
                        'payment_type' => $request->payment_type,
                        'gross_amount' => $request->gross_amount
                    ]);
                }
                $pembelian->update();
                $user_id = $pembelian->user_id;
                
                // Auto-verify user email after successful payment
                $user = \App\Models\User::find($user_id);
                if ($user && !$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }
                
                // Store payment success flag in session for showing WhatsApp link
                session(['payment_success_' . $order_id => true]);

                // Send success email notification
                try {
                    Mail::to($pembelian->user->email)->send(new PembelianSukses($pembelian));
                } catch (\Exception $e) {
                    // Log error but don't fail the transaction
                    \Log::error('Failed to send purchase success email: ' . $e->getMessage());
                }

                if (
                    $pembelian->paket_id ==
                    '0df8c9b0-d352-448b-9611-abadffc4f46d'
                ) {
                    $bundling = Pembelian::where(
                        'paket_id',
                        '33370256-b734-470a-afe9-c7ca8421f1b3'
                    )
                        ->where('user_id', $user_id)
                        ->where('status', 'Sukses')
                        ->first();
                    if (!$bundling) {
                        $pembelian = new Pembelian();
                        $pembelian->paket_id =
                            '33370256-b734-470a-afe9-c7ca8421f1b3';
                        $pembelian->user_id = $user_id;
                        $pembelian->status = 'Sukses';
                        $pembelian->harga = 0;
                        $pembelian->jenis_pembayaran = 'Bundling';
                        $pembelian->save();
                    }
                }

                if (
                    $pembelian->paket_id ==
                    '33370256-b734-470a-afe9-c7ca8421f1b3'
                ) {
                    $bundling = Pembelian::where(
                        'paket_id',
                        '981ae5b5-a48d-47e6-9cc7-9e79994a3ef0'
                    )
                        ->where('user_id', $user_id)
                        ->where('status', 'Sukses')
                        ->first();
                    if (!$bundling) {
                        $pembelian = new Pembelian();
                        $pembelian->paket_id =
                            '981ae5b5-a48d-47e6-9cc7-9e79994a3ef0';
                        $pembelian->user_id = $user_id;
                        $pembelian->status = 'Sukses';
                        $pembelian->harga = 0;
                        $pembelian->jenis_pembayaran = 'Bundling';
                        $pembelian->save();
                    }
                }

                if (
                    $pembelian->paket_id ==
                    '981ae5b5-a48d-47e6-9cc7-9e79994a3ef0'
                ) {
                    $bundling = Pembelian::where(
                        'paket_id',
                        '0be570c6-7edf-4970-bd99-304d0626f9ff'
                    )
                        ->where('user_id', $user_id)
                        ->where('status', 'Sukses')
                        ->first();
                    if (!$bundling) {
                        $pembelian = new Pembelian();
                        $pembelian->paket_id =
                            '0be570c6-7edf-4970-bd99-304d0626f9ff';
                        $pembelian->user_id = $user_id;
                        $pembelian->status = 'Sukses';
                        $pembelian->harga = 0;
                        $pembelian->jenis_pembayaran = 'Bundling';
                        $pembelian->save();
                    }
                }
            } elseif (
                $request->transaction_status == 'deny' ||
                $request->transaction_status == 'cancel' ||
                $request->transaction_status == 'expire'
            ) {
                $pembelian = Pembelian::find($order_id);
                $oldStatus = $pembelian->status;
                $pembelian->status =
                    $pembelian->status == 'Sukses'
                        ? $pembelian->status
                        : 'Gagal';
                $pembelian->update();

                // Send failure email notification if status changed to Gagal
                if ($oldStatus !== 'Gagal' && $pembelian->status === 'Gagal') {
                    try {
                        Mail::to($pembelian->user->email)->send(new PembelianGagal($pembelian));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send failure email: ' . $e->getMessage());
                    }
                }
            }
        }
    }
    private function processBundling($paket_id, $user_id)
    {
        $bundlingPackages = config('bundling.packages');

        if (array_key_exists($paket_id, $bundlingPackages)) {
            $newPaketId = $bundlingPackages[$paket_id];

            $existingPembelian = Pembelian::where('paket_id', $newPaketId)
                ->where('user_id', $user_id)
                ->where('status', 'Sukses')
                ->first();

            if (!$existingPembelian) {
                Pembelian::create([
                    'paket_id' => $newPaketId,
                    'user_id' => $user_id,
                    'status' => 'Sukses',
                    'harga' => 0,
                    'jenis_pembayaran' => 'Bundling',
                ]);
            }
        }
    }
}
