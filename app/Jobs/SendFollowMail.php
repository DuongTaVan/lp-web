<?php

namespace App\Jobs;

use App\Mail\SendMailFollow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFollowMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $email;
    private $title;
    private $body;
    private $student;
    private $teacher;
    private $titleMail;

    public function __construct(string $titleMail, string $email, string $student, string $teacher, string $title = '', string $body = '')
    {
        $this->titleMail = $titleMail;
        $this->email = $email;
        $this->student = $student;
        $this->teacher = $teacher;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toUser = new SendMailFollow($this->titleMail, $this->student, $this->teacher, $this->title, $this->body);
        Mail::to($this->email)->send($toUser);
    }
}
