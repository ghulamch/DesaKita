<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Blade;

class DynamicMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $content, $data = [])
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if (str_starts_with($this->content, 'view:')) {
            $viewName = str_replace('view:', '', $this->content);
            return new Content(
                view: $viewName,
                with: $this->data
            );
        }

        return new Content(
            htmlString: Blade::render($this->content, $this->data),
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
