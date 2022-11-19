<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalCourse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $fullName
     * @var $title
     */
    public $fullNameTeacher;
    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullNameTeacher)
    {
        $this->fullNameTeacher = $fullNameTeacher;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('portal.mail-templates.approval-course')
            ->with([
                'fullNameTeacher' => $this->fullNameTeacher
            ]);
    }
}
