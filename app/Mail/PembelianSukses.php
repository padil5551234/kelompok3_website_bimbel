<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pembelian;

class PembelianSukses extends Mailable
{
    use Queueable, SerializesModels;

    public $pembelian;

    /**
     * Create a new message instance.
     */
    public function __construct(Pembelian $pembelian)
    {
        $this->pembelian = $pembelian;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembelian Paket Ujian Berhasil',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.pembelian-sukses',
            with: [
                'pembelian' => $this->pembelian,
                'paket' => $this->pembelian->paketUjian,
                'user' => $this->pembelian->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}