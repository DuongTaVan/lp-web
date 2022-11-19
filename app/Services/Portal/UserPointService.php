<?php

namespace App\Services\Portal;

use App\Repositories\UserPointRepository;

class UserPointService extends BaseService

{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return UserPointRepository::class;
    }
}
