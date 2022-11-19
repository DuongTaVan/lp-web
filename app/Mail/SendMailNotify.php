<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailNotify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $title;
    protected $fromUser;
    protected $message;
    protected $url;

    public function __construct(string $title = '', string $fromUser = '', string $message, string $url)
    {
        $this->title = $title;
        $this->fromUser = $fromUser;
        $this->message = $message;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.mail-templates.notify-email')
            ->with([
                'fromUser' => $this->fromUser,
                'content' => $this->message,
                'url' => $this->url
            ]);
    }
}
