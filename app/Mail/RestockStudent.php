<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RestockStudent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $course
     * @var $courseUser
     */
    protected $title;
    protected $course;
    protected $courseUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $course, $courseUser)
    {
        $this->title = $title;
        $this->course = $course;
        $this->courseUser = $courseUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.mail-templates.teacher_restock_email')
            ->with([
                'course' => $this->course,
                'courseUser' => $this->courseUser,
            ]);
    }
}
