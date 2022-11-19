<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMailNotify;
use Illuminate\Support\Facades\Mail;

class SendNotifyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $fromUser;
    private $toUser;
    private $message;
    private $url;

    public function __construct(string $fromUser, string $toUser, string $message, $url)
    {
        $this->fromUser = $fromUser;
        $this->toUser = $toUser;
        $this->message = $message;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SendMailNotify('', $this->fromUser, $this->message, $this->url);
        Mail::to($this->toUser)->send($email);
    }
}
