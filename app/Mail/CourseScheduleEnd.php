<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseScheduleEnd extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $body
     */
    public $title;
    public $body;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $title, string $body, $data)
    {
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.student-mypage.course_schedule_end');
    }
}
