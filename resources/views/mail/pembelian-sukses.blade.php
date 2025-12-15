<x-mail::message>
# 🎉 Pembayaran Berhasil!

Halo **{{ $user->name }}**,

Selamat! Pembelian paket ujian Anda telah berhasil diproses dan diverifikasi.

## 📋 Detail Pembelian
- **Paket Ujian**: {{ $paket->nama }}
- **Harga**: Rp {{ number_format($pembelian->harga, 0, ',', '.') }}
- **Status**: {{ $pembelian->status }}
- **Tanggal Pembelian**: {{ $pembelian->created_at->format('d M Y H:i') }}
- **Tanggal Verifikasi**: {{ $pembelian->verified_at ? $pembelian->verified_at->format('d M Y H:i') : '-' }}

@if($paket->whatsapp_group_link)
## 📱 Bergabung ke Grup WhatsApp
Anda dapat bergabung ke grup WhatsApp untuk informasi lebih lanjut dan komunikasi dengan tim kami:

<x-mail::button :url="$paket->whatsapp_group_link" color="success">
    Gabung Grup WhatsApp
</x-mail::button>
@endif

## 🚀 Langkah Selanjutnya
- Anda sekarang dapat mengakses semua materi dan ujian dalam paket ini
- Silakan masuk ke dashboard Anda untuk memulai pembelajaran
- Jika ada pertanyaan, jangan ragu untuk menghubungi kami

Terima kasih telah mempercayai layanan kami!

Salam,<br>
{{ config('app.name') }} Team
</x-mail::message>