<?php

namespace App\Services\Client\Teacher;

use App\Enums\DBConstant;
use App\Repositories\PurchaseDetailRepository;
use App\Repositories\PurchaseRepository;
use App\Services\BaseService;

class PurchaseDetailService extends BaseService
{
    protected $purchaseRepository;

    /**
     * PurchaseGiftService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->purchaseRepository = app(PurchaseRepository::class);
    }

    public function repository()
    {
        return PurchaseDetailRepository::class;
    }

    /**
     * Get option course.
     *
     * @param int $id
     * @return mixed
     */
    public function getOption(int $id)
    {
        $purchased = $this->purchaseRepository
            ->findWhere([
                'course_schedule_id' => $id,
                'status' => DBConstant::PURCHASES_STATUS_CAPTURED,
            ]);

        if (!$purchased->count()) {
            return null;
        }

        return $this->repository->getOptionByPurchaseId($purchased->pluck('purchase_id')->toArray());
    }
}
