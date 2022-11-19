<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentSendMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $fullName
     * @var $title
     */
    public $fullName;
    public $title;
    public $messageDetail;
    public $fullNameStudent;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName, $fullNameStudent, $messageDetail)
    {
        $this->fullName = $fullName;
        $this->fullNameStudent = $fullNameStudent;
        $this->title = $title;
        $this->messageDetail = $messageDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('portal.mail-templates.student_send_message');
    }
}
