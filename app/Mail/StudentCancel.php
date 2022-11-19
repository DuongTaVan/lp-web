<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentCancel extends Mailable implements ShouldQueue
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
    protected $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $course, $teacherName, $userName)
    {
        $this->title = $title;
        $this->course = $course;
        $this->teacherName = $teacherName;
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
            ->view('client.student-mypage.student-cancel-email')
            ->with([
                'course' => $this->course,
                'teacherName' => $this->teacherName,
                'userName' => $this->userName
            ]);
    }
}
