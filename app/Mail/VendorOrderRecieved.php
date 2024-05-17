<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class VendorOrderRecieved extends Mailable
{
    use Queueable, SerializesModels;

    private $newOrder;
    private $product;
    private $customer;
    private $vendor;

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $newOrder , $product, $vendor)
    {
        //
        $this->customer = $customer;
        $this->newOrder = $newOrder;
        $this->product = $product;
        $this->vendor = $vendor;
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
            subject: 'Order Recieved',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.mail.orderReceived',
            with: [
                'customer' => $this->customer,
                'newOrder' => $this->newOrder,
                'product' => $this->product,
                'vendor' => $this->vendor,
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
