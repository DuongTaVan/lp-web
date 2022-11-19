<?php

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\PageView;
use App\Traits\EloquentTrait;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class PageViewRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PageViewRepositoryEloquent extends BaseRepository implements PageViewRepository
{
    use EloquentTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PageView::class;
    }

    /**
     * Get Sum Page View
     *
     * @param $request
     *
     * @return mixed
     */
    public function getSumPageView($request)
    {
        // Set variable
        $category = $request->category;
        // $month = $request->month;
        $date = [
            'start_date' => $request->start_date ?? now()->firstOfMonth(),
            'end_date' => $request->end_date ?? now()
        ];

        // Set value with category type
        $isTopPage = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_0);
        $isSkills = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_1);
        $isConsultation = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_2);
        $isFortunetelling = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_3);

        $pageViews = $this->model->where([
            ['viewed_at', '>=', now()->parse($date['start_date'])],
            ['viewed_at', '<=', now()->parse($date['end_date'])->endOfDay()],
        ]);

        if ($category != 0) {
            $pageViews = $pageViews->where([
                ['is_top_page', '=', $isTopPage],
                ['is_skills', '=', $isSkills],
                ['is_consultation', '=', $isConsultation],
                ['is_fortunetelling', '=', $isFortunetelling]
            ]);
        }
        // else {
        //     $pageViews = $pageViews->where([
        //         ['is_top_page', '=', 0],
        //     ]);
        // }

        return $pageViews->get();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get sum page view teacher
     *
     * @param $data
     *
     * @return mixed
     */
    public function getSumTeacherPageView($data)
    {
        return $this->model
            ->selectRaw('
                SUM(view_count) as view_count,SUM(is_skills) as is_skills,SUM(is_consultation) as is_consultation,SUM(is_fortunetelling) as is_fortunetelling
            ')
            ->where('to_user_id', $data['userId'])
            ->where('viewed_at', '>=', $data['startDate'])
            ->where('viewed_at', '<=', $data['endDate'])
            ->first();
    }

    /**
     * Get Sum View Count.
     *
     * @return mixed
     */
    public function getSumViewCount()
    {
        return $this->model->selectRaw('SUM(view_count) as pvvc, to_course_schedule_id')->groupBy('to_course_schedule_id');
    }

    public function getOneScheduleOfCourseRecently()
    {
//        $courseSchedules = $this->model
//            ->join('courses', function ($q) {
//                $q->on('course_schedules.course_id', '=', 'courses.course_id')
//                    ->where('courses.type', DBConstant::COURSE_TYPE_MAIN);
//            })
//            ->where('course_schedules.type', DBConstant::COURSE_TYPE_MAIN)
//            ->whereIn('course_schedules.status', [
//                DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
//                DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
//                DBConstant::COURSE_SCHEDULES_STATUS_RECORDED
//            ])
//            ->select(DB::raw('ROW_NUMBER() OVER(PARTITION BY course_schedules.course_id ORDER BY course_schedules.start_datetime ASC) rowNumber, course_schedules.course_schedule_id'))
//            ->orderBy('viewed_at')
//            ->get();
        $courseSchedules = $this->model
            ->join('course_schedules as cs', 'cs.course_schedule_id', '=', 'page_views.to_course_schedule_id')
            ->where([
                'user_id' => auth('client')->id()
            ])
            ->select(DB::raw('ROW_NUMBER() OVER(PARTITION BY cs.course_id ORDER BY page_views.viewed_at desc) rowNumber, page_views.id'))
            ->get();

        return $courseSchedules->filter(function ($item) {
            return $item->rowNumber === 1;
        })->pluck('id')->toArray();
    }
}
