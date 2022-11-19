<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HoldingRequestTeacher extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $courseSchedule;
    public $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($teacher, $courseSchedule)
    {
        $this->courseSchedule = $courseSchedule;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【Lappi】新規のご予約がありました。')
            ->view('client.mail-templates.holding-request-teacher');
    }
}
