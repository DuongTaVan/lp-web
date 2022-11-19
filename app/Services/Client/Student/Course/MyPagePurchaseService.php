<?php


namespace App\Services\Client\Student\Course;


use App\Enums\Constant;
use App\Repositories\CourseScheduleRepository;
use App\Services\BaseService;
use App\Traits\CourseImageTrait;

class MyPagePurchaseService extends BaseService
{
    use CourseImageTrait;
    /**
     * @return string
     */
    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    /**
     * MyPagePurchaseService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Course Schedule Purchase List
     */
    public function courseSchedulePurchaseList($request)
    {
        $request->merge([
            'perPage' => $request->input('per_page', Constant::PER_PAGE_DEFAULT),
            'page' => $request->input('page', Constant::PAGE_DEFAULT),
        ]);

        $courseSchedules = $this->repository->getCourseSchedulePurchase($request->all());

        // Check time start course schedule.
        if (count($courseSchedules) > 0) {
            foreach ($courseSchedules as $courseSchedule) {
                $start = $courseSchedule->start_datetime->diffInMinutes(now(), false);
                $end = $courseSchedule->end_datetime->diffInMinutes(now(), false);

                if (-$start > 15) {
                    $courseSchedule['prepare_start_room'] = true;
                }
                if ($end < 0) {
                    $courseSchedule['during_time'] = true;
                }
            }
        }
        $this->getImageOfSchedules($courseSchedules);

        return $courseSchedules;
    }
}
