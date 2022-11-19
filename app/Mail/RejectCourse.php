<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectCourse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $fullName
     * @var $title
     */
    protected $fullName;
    protected $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName)
    {
        $this->fullName = $fullName;
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
            ->view('portal.mail-templates.reject-course')
            ->with([
                'fullName' => $this->fullName
            ]);
    }
}
