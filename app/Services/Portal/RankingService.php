<?php

namespace App\Services\Portal;

use App\Repositories\RankingRepository;

class RankingService extends BaseService

{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return RankingRepository::class;
    }
}
