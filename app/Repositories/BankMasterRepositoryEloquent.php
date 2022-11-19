<?php

namespace App\Repositories;

use App\Enums\DBConstant;
use App\Models\BankMaster;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BankAccountRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BankMasterRepositoryEloquent extends BaseRepository implements BankMasterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return BankMaster::class;
    }

    /**
     * List bank.
     *
     * @return mixed
     */
    public function listBank()
    {
        return $this->model->where('type', DBConstant::BANK_TYPE)->get();
    }

    /**
     * Get data bank.
     *
     * @param $text
     * @return mixed
     */
    public function getDataBank($text)
    {
        return $this->model
            ->where('type', DBConstant::BANK_TYPE)
            ->where('name', 'like', $text . '%')->get();
    }

    /**
     * List branch.
     *
     * @return mixed
     */
    public function listBranch()
    {
        return $this->model->where('type', DBConstant::BRANCH_TYPE)->get();
    }

    /**
     * Get data branch.
     *
     * @param $bank
     * @param $text
     * @return false|mixed
     */
    public function getDataBranch($bank, $text)
    {
        $bank = $this->model->where('type', DBConstant::BANK_TYPE)->where('name', $bank)->first();
        if (isset($bank) && isset($text)) {
            return $this->model->where('type', DBConstant::BRANCH_TYPE)->where('parent_id', $bank->code)->where(function ($query) use ($text) {
                $query->where('name', 'like', $text . '%')->orWhere('code_number', $text);
            })->get();
        }
        if (isset($bank)) {
            return $this->model->where('type', DBConstant::BRANCH_TYPE)->where('parent_id', $bank->code)->get();
        }
        return [];
    }
}
