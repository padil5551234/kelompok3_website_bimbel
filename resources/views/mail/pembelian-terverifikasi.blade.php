<x-mail::message>
# ✅ Pembayaran Berhasil Diverifikasi!

Halo **{{ $user->name }}**,

Kabar baik! Pembayaran manual Anda telah berhasil diverifikasi oleh tim kami.

## 📋 Detail Pembelian
- **Paket Ujian**: {{ $paket->nama }}
- **Harga**: Rp {{ number_format($pembelian->harga, 0, ',', '.') }}
- **Status**: {{ $pembelian->status }}
- **Tanggal Upload**: {{ $pembelian->created_at->format('d M Y H:i') }}
- **Tanggal Verifikasi**: {{ $pembelian->verified_at ? $pembelian->verified_at->format('d M Y H:i') : '-' }}

## 🚀 Selamat! Anda Sekarang Dapat:
- Mengakses semua materi dalam paket ini
- Mengikuti ujian yang tersedia
- Mendapatkan sertifikat setelah menyelesaikan requirements
- Bergabung ke grup WhatsApp (jika tersedia)

@if($paket->whatsapp_group_link)
## 📱 Bergabung ke Grup WhatsApp
Bergabunglah dengan grup WhatsApp untuk mendapatkan informasi terbaru dan berinteraksi dengan peserta lain:

<x-mail::button :url="$paket->whatsapp_group_link" color="success">
    Gabung Grup WhatsApp
</x-mail::button>
@endif

## 🎯 Langkah Selanjutnya
1. **Masuk ke Dashboard**: Akses akun Anda untuk melihat paket yang telah berhasil diverifikasi
2. **Mulai Belajar**: Jelajahi materi dan mulai perjalanan pembelajaran Anda
3. **Ikuti Ujian**: Selesaikan ujian untuk mengukur pemahaman Anda

Terima kasih telah mempercayai layanan {{ config('app.name') }}!

Salam,<br>
{{ config('app.name') }} Team
</x-mail::message>