<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyImage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $title;
    private $status;
    private $user_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $status, $user_name)
    {
        $this->title = $title;
        $this->status = $status;
        $this->user_name = $user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->status === 0) {
            return $this->view('portal.mails.verify-image')->subject('【Lappi】本人確認完了のお知らせ。')->with([
                'title' => $this->title,
                'user_name' => $this->user_name,
            ]);
        } else {
            return $this->view('portal.mails.reject-verify-image')->subject('【Lappi】本人確認の審査否認のお知らせ。')->with([
                'title' => $this->title,
                'user_name' => $this->user_name,
            ]);
        }
    }
}
