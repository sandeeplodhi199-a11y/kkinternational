<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryCustomerMail extends Mailable
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
            subject: 'We Received Your Enquiry — ' . config('app.name', 'Hisab Mittra CRM'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.enquiry-customer',
            with: ['enquiry' => $this->enquiry],
        );
    }
}