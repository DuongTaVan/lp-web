<?php


namespace App\Services\Client\Student;


use App\Repositories\UserPointRepository;
use App\Services\BaseService;
use App\Traits\ManageFile;

class MyPagePurchasePointService extends BaseService
{
    use ManageFile;
    public function repository()
    {
        return UserPointRepository::class;
    }

    public function getListPoint($request)
    {
        return $this->repository->getMyPagePoint($request);
    }

    /**
     * Get point balance.
     *
     * @param $userId
     * @return mixed
     */
    public function getPointUser($userId){
        return $this->repository->getCurrentPointsBalance($userId);
    }
}