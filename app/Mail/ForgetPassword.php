<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class ForgetPassword extends Mailable
{
    use Queueable, SerializesModels;

    private $usertype;
    private $user;

    /**
     * Create a new message instance.
     */
    public function __construct($usertype, $user)
    {
        //
        $this->usertype = $usertype;
        $this->user = $user;
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
            subject: 'Forget Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Encrypt the necessary data
        $user_id = Crypt::encryptString(json_encode([
            'id' => $this->user['id'],
        ]));

        $userType = Crypt::encryptString(json_encode([
            'usertype' => $this->usertype,
        ]));

        // Generate the URL
        $url = route('resetPasswordView', ['id' => $user_id, 'usertype' => $userType]);

        Session::put('resetRoute','true');


        return new Content(
            view: 'mail.resetpassword',
            with: [
                'usertype' => $this->usertype,
                'user' => $this->user,
                'url' => $url,
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
