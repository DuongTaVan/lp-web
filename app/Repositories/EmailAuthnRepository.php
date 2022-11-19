<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EmailAuthnRepository.
 *
 * @package namespace App\Repositories;
 */
interface EmailAuthnRepository extends RepositoryInterface
{
    /**
     * Get account to active
     *
     * @param $request
     * @return mixed
     */
    public function getAccount($request);

    /**
     * Delete account exists
     *
     * @param $email
     * @return mixed
     */
    public function deleteAccount($email);

    /**
     * Get token to check expired
     *
     * @param $request
     * @return mixed
     */
    public function getToken($request);
}
