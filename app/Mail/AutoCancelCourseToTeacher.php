<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AutoCancelCourseToTeacher extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $body
     */
    protected $title;
    protected $fullName;
    protected $course;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName, $course)
    {
        $this->title = $title;
        $this->fullName = $fullName;
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.mail-templates.auto-cancel-course-teacher')
            ->with([
                'fullName' => $this->fullName,
                'course' => $this->course
            ]);
    }
}
