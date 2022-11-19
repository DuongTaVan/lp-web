<?php

declare(strict_types=1);

namespace App\Services\Client\Student;

use App\Enums\Constant;
use App\Repositories\CourseScheduleRepositoryEloquent;
use App\Repositories\PurchaseDetailRepository;
use App\Services\BaseService;
use App\Traits\CourseImageTrait;
use Illuminate\Support\Facades\Auth;
use function Deployer\option;

class MyPagePurchaseHistoryService extends BaseService
{
    use CourseImageTrait;
    public $purchaseDetailRepository;

    public function __construct()
    {
        parent::__construct();
        $this->purchaseDetailRepository = app(PurchaseDetailRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return CourseScheduleRepositoryEloquent::class;
    }

    /**
     * List purchase history.
     */
    public function getList($request)
    {
        return $this->repository->getListPurchaseHistory($request);
    }

    /**
     * Purchase Detail.
     *
     * @param $id
     *
     * @return mixed
     */
    public function purchaseDetail($id)
    {
        return $this->purchaseDetailRepository->getDataDetail($id);
    }

    /**
     * Get order review.
     *
     * @param $request
     *
     * @return mixed
     */
    public function getOrderReview($request)
    {
        return $this->repository->getOrderReview($request);
    }
    /**
     * Get all order review.
     *
     * @param $request
     *
     * @return mixed
     */
    public function getAllOrderReview($request)
    {
        return $this->repository->getAllOrderReview($request);
    }

    /**
     * Get order not review.
     *
     * @param $request
     * @return mixed
     */
    public function getOrderNotReview($request)
    {
        return $this->repository->getOrderNotReview($request);
    }

    /**
     * Get order reviewed.
     *
     * @param $request
     * @return mixed
     */
    public function getOrderReviewed($request)
    {
        return $this->repository->getOrderReviewed($request);
    }

    /**
     * Get course purchasing.
     *
     * @param $request
     *
     * @return array
     */
    public function getRoomMessage($request)
    {
        $userId = auth('client')->id();

        if (Auth::guard('client')->check()) {
            $data = $request->all();
            $data['user_id'] = $userId;
            $data['page'] = $request->input('page', Constant::PAGE_DEFAULT);
            $data['perPage'] = $request->input('perPage', Constant::PER_PAGE_DEFAULT);
            $data['year'] = $request->input('year', now()->year);
            $data['option'] = $request->input('option', Constant::OPTION_TAB_ONE);
            $courseSchedules = $this->repository->getCourseSchedulePurchased($data);
            if ((int)$data['option'] === 4 || (int)$data['option'] === 5) {
                $total = $courseSchedules['total'];
                $courseSchedules = $courseSchedules['courseSchedules'];
            } else {
                $total = $courseSchedules->count();
                // get images course schedule
                $this->getImageOfSchedules($courseSchedules);
            }

            return [
                'option' => $data['option'],
                'year' => $data['year'],
                'courseSchedules' => $courseSchedules,
                'pagination' => [
                    'total' => $total,
                    'totalPage' => (int)ceil($total / (int)$data['perPage']),
                    'limit' => $data['perPage'],
                    'page' => $data['page'],
                ]
            ];
        }

        return [];
    }

    /**
     * Get total course_schedule message
     *
     * @param $coursePurchasing
     * @param $courseNotPurchase
     * @param $coursePurchased
     *
     * @return int
     */
    public function totalCourseScheduleMessage($coursePurchasing, $courseNotPurchase, $coursePurchased)
    {
        $coursePurchasing = !empty($coursePurchasing['courseSchedules']) ? $coursePurchasing['courseSchedules']->total() : 0;
        $courseNotPurchase = !empty($courseNotPurchase['courseSchedules']) ? $courseNotPurchase['courseSchedules']->total() : 0;
        $coursePurchased = !empty($coursePurchased['courseSchedules']) ? $coursePurchased['courseSchedules']->total() : 0;

        return $coursePurchasing + $courseNotPurchase + $coursePurchased;
    }

    /**
     * Get total course schedule review
     *
     * @param $courseScheduleReview
     * @return array
     */
    public function totalCourseScheduleReview($courseScheduleReview)
    {
        $reviewed = 0;
        $notReviewed = 0;
        if (!empty($courseScheduleReview['listSchedulesReviews']) && count($courseScheduleReview['listSchedulesReviews']) > 0) {
            foreach ($courseScheduleReview['listSchedulesReviews'] as $courseSchedule) {
                if ($courseSchedule['comment'] == null) {
                    $notReviewed++;
                } else {
                    $reviewed++;

                }
            }
        }

        return [
            'reviewed' => $reviewed,
            'notReviewed' => $notReviewed
        ];
    }

}
