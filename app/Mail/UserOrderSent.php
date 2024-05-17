<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class UserOrderSent extends Mailable
{
    use Queueable, SerializesModels;

    private $order;
    private $customer;
    private $product;

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $order, $product)
    {
        //
        $this->customer = $customer;
        $this->order = $order;
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('marketplaceconnectofficial@gmail.com', 'Market Place Connect'),
            replyTo:[
                new Address('marketplaceconnectofficial@gmail.com', 'Market Place Connect')
            ],
            subject: 'Order Sent',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'user.emails.orderSent',
            with: [
                'customer' => $this->customer,
                'order' => $this->order,
                'product' => $this->product,
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
