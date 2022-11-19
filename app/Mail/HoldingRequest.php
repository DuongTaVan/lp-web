<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HoldingRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $courseSchedule;
    public $user;
    public $teacher;
    public $listCourseSchedules;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($teacher, $courseSchedule, $user, $listCourseSchedules)
    {
        $this->courseSchedule = $courseSchedule;
        $this->user = $user;
        $this->teacher = $teacher;
        $this->listCourseSchedules = $listCourseSchedules;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('client.mail-templates.holding-request')
            ->subject('【Lappi】サービス購入のご確認')
            ->with(['courseSchedule' => $this->courseSchedule, 'fullName' => $this->user, 'teacher' => $this->teacher, 'listCourseSchedules' => $this->listCourseSchedules]);
    }
}
