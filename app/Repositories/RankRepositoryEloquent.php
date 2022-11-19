<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Models\Rank;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RankRepositoryEloquent.
 */
class RankRepositoryEloquent extends BaseRepository implements RankRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Rank::class;
    }

    /**
     * Get Rank Data.
     *
     * @return mixed|void
     */
    public function getRankData()
    {
        return $this->model->orderBy('rank_level', Constant::ORDER_BY_ASC)->get();
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
