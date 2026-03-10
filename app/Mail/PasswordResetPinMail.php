<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetPinMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $pin;
    public string $userEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(string $pin, string $userEmail)
    {
        $this->pin = $pin;
        $this->userEmail = $userEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Reset PIN Code',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pin-reset',
        );
    }
}
