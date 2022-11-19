<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherRequestTransfer extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $teacher;
    public $money;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($money, $teacher)
    {
        $this->teacher = $teacher;
        $this->money = $money;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('client.mail-templates.teacher-request-transfer')
            ->subject('【Lappi】振込申請完了のお知らせ。')
            ->with(['money' => $this->money, 'teacher' => $this->teacher]);
    }
}
