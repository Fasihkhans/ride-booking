<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DriverAccountCreatationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $randomPassword;
    Public $name;
    public $email;

    /**
     * Create a new message instance.
     */
    public function __construct(string $randomPassword,string $name,string $email)
    {
        $this->randomPassword = $randomPassword;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to DartsCars Platform'.$this->randomPassword,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.driver-account-creatation',
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
