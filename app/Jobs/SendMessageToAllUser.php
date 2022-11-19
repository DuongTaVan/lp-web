<?php

namespace App\Jobs;

use App\Services\Client\Common\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageToAllUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $students;
    private $message;
    private $teacherId;
    private $courseScheduleId;
    private $roomType;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $students, $message, $teacherId, $courseScheduleId, $roomType)
    {
        $this->students = $students;
        $this->message = $message;
        $this->teacherId = $teacherId;
        $this->courseScheduleId = $courseScheduleId;
        $this->roomType = $roomType;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(FirebaseService $firebaseService)
    {
        foreach ($this->students as $fromUserId) {
            $firebaseService->sendMessage($fromUserId, $this->message, $this->teacherId, $this->courseScheduleId, $this->roomType, true);
        }
    }
}
