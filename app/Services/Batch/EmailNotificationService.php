<?php

namespace App\Services\Batch;


use App\Enums\DBConstant;
use App\Mail\SendMailBatch;
use App\Repositories\EmailNotificationRepositoryEloquent;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Class EmailNotificationService
 * @package App\Services\Portal
 */
class EmailNotificationService extends BaseService
{
    /**
     * EmailNotification repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return EmailNotificationRepositoryEloquent::class;
    }

    /**
     * Batch send mail
     *
     * @return array
     */
    public function sendMail(): array
    {
        $emailNotifications = $this->repository->getRecordsToBeSent();
        DB::beginTransaction();
        try {
            foreach ($emailNotifications as $emailNotification) {
                $sendMailStatus = Mail::to($emailNotification->to_email)->queue(new SendMailBatch($emailNotification->title, nl2br($emailNotification->body)));
                $this->repository->update([
                    'status' => $sendMailStatus === 0 ? DBConstant::EMAIL_SENDING_STATUS_SENT : DBConstant::EMAIL_SENDING_STATUS_ERROR,
                    'sent_at' => now(),
                ], $emailNotification->id);
            }
            DB::commit();

            return ['success' => true];

        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
