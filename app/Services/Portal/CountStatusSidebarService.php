<?php

namespace App\Services\Portal;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Repositories\ImagePathRepository;
use App\Repositories\TransferHistoryRepository;
use App\Models\Course;
class CountStatusSidebarService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $transferHistoryRepository;
    public $courseRepository;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->transferHistoryRepository = app(TransferHistoryRepository::class);
        $this->courseRepository = app(Course::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return ImagePathRepository::class;
    }

    /**
     * Get count identity image.
     *
     * @return void
     */
    public function getCountImageIdentity()
    {
        return $this->repository->getCountImageIdentity();
    }

    /**
     * Get count business image.
     *
     * @return void
     */
    public function getCountImageBusiness()
    {
        return $this->repository->getCountImageBusiness();
    }

    /**
     * Get count transfer histories.
     *
     * @return void
     */
    public function getCountTransferHistories()
    {
        return $this->transferHistoryRepository->getCountTransferHistories();
    }

     /**
     * Get count courses pending.
     *
     * @return void
     */
    public function getCountCoursesPending()
    {
        return $this->courseRepository
            ->where('fixed_num', DBConstant::FIXED_NUM_MAX)
            ->where('approval_status', DBConstant::COURSE_NOT_REVIEW)
            ->whereNull('parent_course_id')
            ->whereNotIn('status', [DBConstant::COURSE_STATUS_DRAFT, DBConstant::COURSE_STATUS_PREVIEW])
            ->with(['category', 'user'])
            ->count();
    }
}
