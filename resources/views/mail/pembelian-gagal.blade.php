<x-mail::message>
# ❌ Pembayaran Gagal

Halo **{{ $user->name }}**,

Mohon maaf, pembayaran untuk paket ujian Anda tidak dapat diproses.

## 📋 Detail Pembelian
- **Paket Ujian**: {{ $paket->nama }}
- **Harga**: Rp {{ number_format($pembelian->harga, 0, ',', '.') }}
- **Status**: {{ $pembelian->status }}
- **Tanggal Pembelian**: {{ $pembelian->created_at->format('d M Y H:i') }}

## 🔄 Cara Mengatasi
1. **Periksa Saldo**: Pastikan saldo rekening/dompet digital Anda mencukupi
2. **Periksa Koneksi**: Pastikan koneksi internet Anda stabil
3. **Coba Lagi**: Anda dapat mencoba melakukan pembayaran kembali
4. **Hubungi Bantuan**: Jika masalah berlanjut, hubungi tim customer service kami

## 💬 Butuh Bantuan?
Jika Anda mengalami kesulitan atau memiliki pertanyaan, jangan ragu untuk menghubungi kami:

- **Email**: {{ config('mail.from.address') }}
- **WhatsApp**: +62-812-3456-7890 (Admin Customer Service)

Kami siap membantu Anda menyelesaikan masalah ini.

Salam,<br>
{{ config('app.name') }} Team
</x-mail::message>