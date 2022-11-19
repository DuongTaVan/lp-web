<?php

namespace App\Repositories;

use App\Models\BankAccount;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BankAccountRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BankAccount::class;
    }

    /**
     * Get bank account.
     *
     * @return mixed
     */
    public function getBankAccount()
    {
        return $this->model
            ->where('user_id', auth('client')->user()->user_id)
            ->first();
    }

    public function updateBankAccount($id, $request)
    {
        return $this->model->find($id)->update($request->all());
    }
}
