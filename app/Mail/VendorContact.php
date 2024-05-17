<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class VendorContact extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $email;
    public $subject;
    private $usermessage;
    private $vendor;


    /**
     * Create a new message instance.
     */
    public function __construct($name , $email , $subject , $usermessage , $vendor)
    {
        //
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->usermessage = $usermessage;
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
                new Address($this->email, $this->name)
            ],
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'vendor.mail.contact',
            with: [
                'name' => $this->name,
                'usermessage' => $this->usermessage,
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
