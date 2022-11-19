<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferHistoryMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transferHistory;
    public $teacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transferHistory, $teacher)
    {
        $this->transferHistory = $transferHistory;
        $this->teacher = $teacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('portal.mails.transfer-history')
            ->subject('【Lappi】振込登録完了のお知らせ。');

    }
}
