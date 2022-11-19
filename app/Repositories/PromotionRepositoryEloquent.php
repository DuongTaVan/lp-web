<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Promotion;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PromotionRepositoryEloquent.
 */
class PromotionRepositoryEloquent extends BaseRepository implements PromotionRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Promotion::class;
    }
}
