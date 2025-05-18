<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestCaseApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $testCase;
    public $approver;
    public function __construct($user, $testCase, $approver)
    {
        $this->user = $user;
        $this->testCase = $testCase;
        $this->approver = $approver;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Case Approval Request',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Mail.test-case-approval-request',
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
