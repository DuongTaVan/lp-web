<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentSendMailCourseSchedule extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var $fullName
     * @var $studentFullName
     * @var $title
     * @var $courseSchedule
     * @var $messageDetail
     * @var $checkPurchased
     */
    public $fullName;
    public $studentFullName;
    public $title;
    public $courseSchedule;
    public $messageDetail;
    public $checkPurchased;
    public $enabledRequestRestock;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName, $studentFullName, $messageDetail, $courseSchedule, $checkPurchased, $enabledRequestRestock)
    {
        $this->fullName = $fullName;
        $this->studentFullName = $studentFullName;
        $this->title = $title;
        $this->messageDetail = $messageDetail;
        $this->courseSchedule = $courseSchedule;
        $this->checkPurchased = $checkPurchased;
        $this->enabledRequestRestock = $enabledRequestRestock;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('portal.mail-templates.student_send_message_course_schedule')
            ->with([
                'fullName' => $this->fullName,
                'studentFullName' => $this->studentFullName,
                'messageDetail' => $this->messageDetail,
                'courseSchedule' => $this->courseSchedule,
                'checkPurchased' => $this->checkPurchased,
                'enabledRequestRestock' => $this->enabledRequestRestock
            ]);
    }
}
