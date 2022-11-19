<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteAccount extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $body
     */
    protected $title;
    protected $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $userName)
    {
        $this->title = $title;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.student-mypage.delete-account-email')
            ->with([
                'userName' => $this->userName
            ]);
    }
}
