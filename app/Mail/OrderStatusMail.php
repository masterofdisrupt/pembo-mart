<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\SystemSetting;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $setting;

    /**
     * Create a new message instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
        $this->setting = SystemSetting::getSingleRecord();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->setting->website . ' Order Status Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.status',
            with: [
                'order' => $this->order,
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
