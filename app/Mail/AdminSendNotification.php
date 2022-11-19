<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSendNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $content
     * @var $title
     * @var $titleMail
     * @var $student
     */
    public $content;
    public $title;
    public $titleMail;
    public $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titleMail, $title, $content, $student)
    {
        $this->titleMail = $titleMail;
        $this->title = $title;
        $this->content = $content;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->titleMail)
            ->view('portal.mail-templates.admin-send-notification');
    }
}
