<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $enquiry;

    public function __construct(array $data)
    {
        $this->enquiry = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Enquiry Received — ' . $this->enquiry['name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-admin',
            with: ['enquiry' => $this->enquiry],
        );
    }
}