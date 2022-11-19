<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ApplicantRepository.
 */
interface BankAccountRepository extends RepositoryInterface
{
    /**
     * @return mixed
     */
    public function getBankAccount();

    /**
     * Update bank account.
     *
     * @param $id
     * @param $request
     * @return mixed
     */
    public function updateBankAccount($id, $request);
}
