<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentCancelCourse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    protected $title;
    protected $fullName;
    protected $course;
    protected $fullNameStudent;
    protected $messageCancel;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName, $course, $fullNameStudent, $messageCancel)
    {
        $this->title = $title;
        $this->fullName = $fullName;
        $this->course = $course;
        $this->fullNameStudent = $fullNameStudent;
        $this->messageCancel = $messageCancel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.mail-templates.teacher-cancel-to-student-email')
            ->with([
                'fullName' => $this->fullName,
                'course' => $this->course,
                'fullNameStudent' => $this->fullNameStudent,
                'messageCancel' => $this->messageCancel
            ]);
    }
}
