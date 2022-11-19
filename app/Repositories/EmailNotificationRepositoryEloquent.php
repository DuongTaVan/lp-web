<?php

namespace App\Repositories;

use App\Enums\DBConstant;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EmailNotificationRepository;
use App\Models\EmailNotification;
use App\Validators\EmailNotificationValidator;

/**
 * Class EmailNotificationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmailNotificationRepositoryEloquent extends BaseRepository implements EmailNotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailNotification::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get records to be sent.
     *
     * @return mixed|void
     */
    public function getRecordsToBeSent()
    {
        return $this->model->where('scheduled_at', '<=', now())
            ->where('status', DBConstant::EMAIL_SENDING_STATUS_NOT_SENT)
            ->get();

    }

}
