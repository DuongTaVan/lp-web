<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PromotionalMessageRepository.
 *
 * @package namespace App\Repositories;
 */
interface PromotionalMessageRepository extends RepositoryInterface
{
    /**
     * List Promotional Message.
     *
     * @param $request
     *
     * @return mixed
     */
    public function listPromotionalMessages($request);
}
