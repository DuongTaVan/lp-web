<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $title;
    protected $body;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $body, $user = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (!$this->user) {
            return $this->subject($this->title)
                ->view('portal.mail-templates.send_mail_reset_password')
                ->with([
                    'url' => $this->body
                ]);
        }

        return $this->subject($this->title)
            ->view('client.mail-templates.reset-password')
            ->with([
                'url' => $this->body,
                'user' => $this->user
            ]);
    }
}
