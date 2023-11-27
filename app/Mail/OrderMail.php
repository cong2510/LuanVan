<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user,$orderIdRef,$tong,$cart;
    /**
     * Create a new message instance.
     */
    public function __construct($user,$orderIdRef,$tong,$cart)
    {
        $this->user = $user;
        $this->orderIdRef = $orderIdRef;
        $this->tong = $tong;
        $this->cart = $cart;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ordersendmail',
            with: [
                'user' => $this->user,
                'orderIdRef' => $this->orderIdRef,
                'tong' => $this->tong,
                'cart' => $this->cart,
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
