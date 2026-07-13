<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ValidasiSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $permohonan;
    public $pemohon;

    public function __construct(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
        $this->pemohon = $permohonan->user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Validasi Selesai - ' . $this->permohonan->nomor_surat_permohonan,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.validasi_selesai',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}