<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TrialExpiringSoonMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Company $company, public int $daysLeft) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your free trial expires in ' . $this->daysLeft . ' days — JobsNepal',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.trial-expiring-soon',
        );
    }
}
