<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestockTeacher extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $course
     * @var $teacherName
     * @var $userName
     */
    protected $title;
    protected $course;
    protected $teacherName;
    protected $courseUser;
    protected $courseScheduleId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $course, $teacherName, $courseUser, $courseScheduleId)
    {
        $this->title = $title;
        $this->course = $course;
        $this->teacherName = $teacherName;
        $this->courseUser = $courseUser;
        $this->courseScheduleId = $courseScheduleId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.mail-templates.student_restock_email')
            ->with([
                'course' => $this->course,
                'teacherName' => $this->teacherName,
                'courseUser' => $this->courseUser,
                'courseScheduleId' => $this->courseScheduleId,
            ]);
    }
}
