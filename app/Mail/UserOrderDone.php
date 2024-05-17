<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class UserOrderDone extends Mailable
{
    use Queueable, SerializesModels;

    private $customer;
    private $newOrder;
    private $product;
    

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $newOrder , $product)
    {
        //
        $this->customer = $customer;
        $this->newOrder = $newOrder;
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
            subject: 'Order Completed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'user.emails.orderDone',
            with: [
                'customer' => $this->customer,
                'newOrder' => $this->newOrder,
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
