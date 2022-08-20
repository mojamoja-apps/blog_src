<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailval)
    {
        $this->mailval = $mailval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to( config('mail.admin_address') )
            ->subject('ブログシステムよりお問い合わせ')
            ->text('mail.contact')          // view だとメール本文が改行されない ->view('mail.contact')
            ->with([
                'mailval' => $this->mailval,
            ]);
    }
}
