<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MessageRepository.
 *
 * @package namespace App\Repositories;
 */
interface MessageRepository extends RepositoryInterface
{
    /**
     * Get list message from promotion
     *
     * @param $request
     *
     * @return mixed
     */
    public function listMessages($request);

    /**
     * Count unread message.
     *
     * @return mixed
     */
    public function getUnReadMessage();
}
