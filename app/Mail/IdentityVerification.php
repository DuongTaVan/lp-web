<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class IdentityVerification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $status
     * @var $fullName
     * @var $titleMail
     */
    public $status;
    public $fullName;
    public $titleMail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titleMail, $fullName, $status)
    {
        $this->titleMail = $titleMail;
        $this->fullName = $fullName;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->titleMail)
            ->view('client.student-mypage.identity-verification');
    }
}
