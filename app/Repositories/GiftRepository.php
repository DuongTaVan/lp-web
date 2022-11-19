<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface GiftRepository.
 *
 * @package namespace App\Repositories;
 */
interface GiftRepository extends RepositoryInterface
{
    /**
     * Get gift by id
     *
     * @param $giftId
     * @return mixed
     */
    public function getGiftById($giftId);
}
