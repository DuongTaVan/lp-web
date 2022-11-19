<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $title
     * @var $body
     * @var $fullName
     */
    protected $title;
    protected $courseSchedules;
    protected $fullName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName, $courseSchedules)
    {
        $this->title = $title;
        $this->courseSchedules = $courseSchedules;
        $this->fullName = $fullName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.student-mypage.test-mail')
            ->with([
                'fullName' => $this->fullName,
                'courseSchedules' => $this->courseSchedules
            ]);
    }
}
