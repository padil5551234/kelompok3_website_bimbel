<x-mail::message>
# ⏳ Pembayaran Menunggu Verifikasi

Halo **{{ $user->name }}**,

Terima kasih! Bukti transfer Anda telah berhasil diupload dan sedang menunggu verifikasi dari tim kami.

## 📋 Detail Pembelian
- **Paket Ujian**: {{ $paket->nama }}
- **Harga**: Rp {{ number_format($pembelian->harga, 0, ',', '.') }}
- **Status**: {{ $pembelian->status }}
- **Tanggal Upload**: {{ $pembelian->created_at->format('d M Y H:i') }}

@if($pembelian->bukti_transfer)
## 📷 Bukti Transfer
Bukti transfer Anda telah berhasil diupload dan akan segera diproses oleh tim verifikasi kami.
@endif

## ⏱️ Waktu Proses Verifikasi
- **Estimasi Waktu**: 1x24 jam (hari kerja)
- **Status**: Menunggu verifikasi manual oleh tim admin

## 💬 Hubungi Admin (Opsional)
Jika Anda ingin mempercepat proses verifikasi, Anda dapat menghubungi admin melalui WhatsApp:

<x-mail::button :url="'https://wa.me/' . ($pembelian->whatsapp_admin ?? '6281234567890') . '?text=Halo admin, saya sudah upload bukti transfer untuk transaksi #' . sprintf('%06d', $pembelian->id)" color="warning">
    Chat Admin via WhatsApp
</x-mail::button>

## 🔔 Notifikasi
Anda akan menerima email konfirmasi setelah pembayaran berhasil diverifikasi oleh tim kami.

Terima kasih telah menggunakan layanan kami!

Salam,<br>
{{ config('app.name') }} Team
</x-mail::message>