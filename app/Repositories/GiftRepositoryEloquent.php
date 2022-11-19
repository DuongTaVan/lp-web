<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\GiftRepository;
use App\Models\Gift;
use App\Validators\GiftValidator;

/**
 * Class GiftRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class GiftRepositoryEloquent extends BaseRepository implements GiftRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Gift::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get gift by id
     *
     * @param $giftId
     * @return mixed
     */
    public function getGiftById($giftId)
    {
        return $this->model
            ->where('gift_id', $giftId)
            ->first();
    }
}
