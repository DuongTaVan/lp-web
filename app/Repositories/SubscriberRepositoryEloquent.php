<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\SubscriberRepository;
use App\Models\Subscriber;
use App\Validators\SubscriberValidator;

/**
 * Class SubscriberRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class SubscriberRepositoryEloquent extends BaseRepository implements SubscriberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscriber::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Insert data subscriber
     *
     * @param $authUserId
     * @param $userId
     * @return mixed
     */
    public function insertDataSubscriber($authUserId, $userId)
    {
        return $this->model->firstOrCreate(
            [
                'from_user_id' => $authUserId,
                'to_user_id' => $userId
            ],
            [
                'from_user_id' => $authUserId,
                'to_user_id' => $userId
            ]
        );
    }
}
