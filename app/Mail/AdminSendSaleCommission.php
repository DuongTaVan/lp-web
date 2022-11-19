<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSendSaleCommission extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $title;
    protected $promotion;
    protected $fullNameTeacher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $promotion, $fullNameTeacher)
    {
        $this->title = $title;
        $this->promotion = $promotion;
        $this->fullNameTeacher = $fullNameTeacher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->view('client.mail-templates.sale-commission-first')
            ->with([
                'promotion' => $this->promotion,
                'fullNameTeacher' => $this->fullNameTeacher
            ]);
    }
}
