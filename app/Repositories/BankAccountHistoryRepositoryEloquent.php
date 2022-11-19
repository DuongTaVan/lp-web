<?php

namespace App\Repositories;

use App\Models\BankAccountHistory;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BankAccountHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BankAccountHistoryRepositoryEloquent extends BaseRepository implements BankAccountHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BankAccountHistory::class;
    }

}
