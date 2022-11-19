<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Repositories\BoxNotificationRepository;
use App\Repositories\BoxNotificationTransContentRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public function repository()
    {
        return BoxNotificationTransContentRepository::class;
    }

    /**
     * Post create box_notification_trans_contents
     *
     * @param $request
     * @return array
     */
    public function createData($request): array
    {
        // 1-1 Create box_notification_trans_contents.
        $request->merge([
            'is_delivered' => DBConstant::BOX_NOTIFICATION_TRANS_CONTENT_IS_DELIVERED['not_delivered'],
            'delivered_at' => null
        ]);
        $this->repository->create($request->all());
        return [
            'success' => true
        ];
    }

    /**
     * Get List Box Notification
     *
     * @param mixed $request
     * @return void
     */
    public function getListBoxNotification($request)
    {
        return $this->repository->getListBoxNotification($request);
    }

    public function show($id)
    {
        return $this->repository->findOrFail($id, ['title', 'body', 'scheduled_at', 'to_type']);
    }
}
