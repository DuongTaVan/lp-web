<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailFollow extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $title;
    protected $body;
    protected $titleMail;
    protected $student;
    protected $teacher;

    public function __construct(string $titleMail, string $student, string $teacher, string $title, string $body)
    {
        $this->titleMail = $titleMail;
        $this->title = $title;
        $this->body = $body;
        $this->student = $student;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->titleMail)
            ->view('client.mail-templates.follow-email')
            ->with([
                'content' => $this->body,
                'title' => $this->title,
                'student' => $this->student,
                'teacher' => $this->teacher
            ]);
    }
}
