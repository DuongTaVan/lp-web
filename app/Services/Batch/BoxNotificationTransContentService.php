<?php

namespace App\Services\Batch;

use App\Enums\DBConstant;
use App\Mail\AdminSendNotification;
use App\Repositories\BoxNotificationRepository;
use App\Repositories\BoxNotificationTransContentRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BoxNotificationTransContentService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $userRepository;
    public $boxNotificationRepository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->boxNotificationRepository = app(BoxNotificationRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return BoxNotificationTransContentRepository::class;
    }

    /**
     * Batch 01 Box notification records creation batch
     *
     * @return array
     */
    public function batch01(): array
    {
        DB::beginTransaction();
        try {
            // 1-1) Get target records to be delivered.
            $boxNotificationTransContents = $this->repository->getRecordsNotDelivered();
            // 1-2) Loop as many times as the number of data at 1-1).
            foreach ($boxNotificationTransContents as $boxNotificationTransContent) {
                $users = [];
                if ($boxNotificationTransContent->to_type === DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE['to_all']) {
                    // 1-2-1) Get all the users
                    $users = $this->userRepository->getAllUser('*');
                } else if ($boxNotificationTransContent->to_type === DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_TYPE['to_teacher']) {
                    // 1-2-2) Get all the specified users.

                    $users = $this->userRepository->getSpecifiedUsers('*');
                    if (count($users)) {
                        foreach ($users as $user) {
                            Mail::to($user->email)->queue(new AdminSendNotification('【Lappi】事務局よりお知らせのメッセージがありました。', $boxNotificationTransContent->title, $boxNotificationTransContent->body, $user->full_name));
                        }
                    }
                }
                if (!count($users)) {
                    break;
                }

                $boxNotificationTransContentId = $boxNotificationTransContent->box_notification_trans_content_id;

                // 1-2-4-1) Create box_notifications records.
                $this->boxNotificationRepository->createBoxNotification($users->toArray(), $boxNotificationTransContentId);

                // 1-2-5) Update record.
                $this->repository->delivered($boxNotificationTransContentId);
                break;
            }
            DB::commit();

            return [
                'success' => true
            ];
        } catch (Exception $e) {
            DB::rollBack();

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
