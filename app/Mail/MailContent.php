<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailContent extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('shop.mail.email-forgot-pw')->with([
        //     'data' => $this->data
        // ])->subject('Reset Password!');
        return $this->view('shop.mail.email', [
                        'data' => $this->data
                    ])->subject($this->data['title']);
    }
}


