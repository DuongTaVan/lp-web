<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailResendTransferHistory extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $teacher)
    {
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('portal.mails.transfer-history-report-teacher')
            ->subject('【Lappi】振込未完了のお知らせ。');
    }
}
