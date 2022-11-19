<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\PageViewRepository;
use App\Repositories\SaleRepository;
use App\Repositories\UserRepository;

class HomeService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $userRepository;
    public $applicantRepository;
    public $courseScheduleRepository;
    public $pageViewRepository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->pageViewRepository = app(PageViewRepository::class);
    }

    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return SaleRepository::class;
    }

    /**
     * Get data to show on dashboard
     *
     * @param $request
     * @return array
     */
    public function getData($request)
    {
        // Set variable
        $month = $request->month;

        $date = [
            'start_date' => $request->start_date ?? now()->firstOfMonth(),
            'end_date' => $request->end_date ?? now()
        ];

        // 1.1 Get sales data.
        $sales = $this->repository->getSumData($request);

        $numOfSales = $this->repository->getTotalNumOfSales($request);

        // 1.2 Get the number of newly registered student users.
        $newStudents = $this->userRepository->getNewlyUsers($date, DBConstant::USER_TYPE_STUDENT);

        // 1.3 Get the accumulated number of registered student users.
        $registeredStudents = $this->userRepository->getRegisteredUsers($month, DBConstant::USER_TYPE_STUDENT);

        // 1.4 Get the number of newly registered teacher users.
        $newTeachers = $this->userRepository->getNewlyUsers($date, DBConstant::USER_TYPE_TEACHER);

        // 1.5 Get the accumulated number of registered teacher users.
        $registeredTeachers = $this->userRepository->getRegisteredUsers($month, DBConstant::USER_TYPE_TEACHER);

        // 1.6 Get page views.
        $pageViews = $this->pageViewRepository->getSumPageView($request);

        // 1.7 Get student's cancellation count.
        $totalCancellationStudents = $this->applicantRepository->getStudentCancellationCount($request);

        // 1.8 Get teacher's cancellation count.
        $totalCancellationTeachers = $this->courseScheduleRepository->getTeacherCancellationCount($request);

        // home all categories
        $chartDefault1 = [
            $sales['total_sales_fortunetelling'],
            $sales['total_sales_consultation'],
            $sales['total_sales_skills'] + $sales['total_sales_skills_sub']
        ];
        $chartDefault2 = [
            $sales['sales_male'],
            $sales['sales_female'],
            $sales['sales_not_known'],
            $sales['sales_unapplicable'],
        ];
        $chartDefault3 = [
            $sales['sales_10s'],
            $sales['sales_20s'],
            $sales['sales_30s'],
            $sales['sales_40s'],
            $sales['sales_50s'],
            $sales['sales_60s']
        ];
        // home live streaming
        $chartLive1 = [
            $sales['sales_skills_genre_1'],
            $sales['sales_skills_genre_2'],
            $sales['sales_skills_genre_3'],
            $sales['sales_skills_genre_4'],
            $sales['sales_skills_genre_5'],
            $sales['sales_skills_genre_6'],
            $sales['sales_skills_genre_7'],
            $sales['sales_skills_genre_8'],
            $sales['sales_skills_genre_9'],
            $sales['sales_skills_genre_10'],
            $sales['sales_skills_genre_11'],
            $sales['sales_skills_genre_12'],
            $sales['sales_skills_genre_13']
        ];
        $chartLive2 = [
            $sales['sales_male'],
            $sales['sales_female'],
            $sales['sales_not_known'],
            $sales['sales_unapplicable'],
        ];
        $chartLive3 = [
            $sales['sales_10s'],
            $sales['sales_20s'],
            $sales['sales_30s'],
            $sales['sales_40s'],
            $sales['sales_50s'],
            $sales['sales_60s']
        ];
        // home online trouble
        $chartTrouble1 = [
            $sales['sales_consultation_genre_1'],
            $sales['sales_consultation_genre_2'],
            $sales['sales_consultation_genre_3'],
            $sales['sales_consultation_genre_4'],
            $sales['sales_consultation_genre_5'],
            $sales['sales_consultation_genre_6'],
            $sales['sales_consultation_genre_7'],
            $sales['sales_consultation_genre_8'],
            $sales['sales_consultation_genre_9'],
            $sales['sales_consultation_genre_10'],
        ];
        $chartTrouble2 = [
            $sales['sales_male'],
            $sales['sales_female'],
            $sales['sales_not_known'],
            $sales['sales_unapplicable'],
        ];
        $chartTrouble3 = [
            $sales['sales_10s'],
            $sales['sales_20s'],
            $sales['sales_30s'],
            $sales['sales_40s'],
            $sales['sales_50s'],
            $sales['sales_60s']
        ];
        //home online fortune telling
        $chartTelling1 = [
            $sales['sales_fortunetelling_genre_1'],
            $sales['sales_fortunetelling_genre_2'],
            $sales['sales_fortunetelling_genre_3'],
            $sales['sales_fortunetelling_genre_4'],
            $sales['sales_fortunetelling_genre_5'],
            $sales['sales_fortunetelling_genre_6'],
            $sales['sales_fortunetelling_genre_7'],
            $sales['sales_fortunetelling_genre_8'],
            $sales['sales_fortunetelling_genre_9'],
            $sales['sales_fortunetelling_genre_10'],
            $sales['sales_fortunetelling_genre_11']
        ];
        $chartTelling2 = [
            $sales['sales_male'],
            $sales['sales_female'],
            $sales['sales_not_known'],
            $sales['sales_unapplicable'],
        ];
        $chartTelling3 = [
            $sales['sales_10s'],
            $sales['sales_20s'],
            $sales['sales_30s'],
            $sales['sales_40s'],
            $sales['sales_50s'],
            $sales['sales_60s']
        ];

        return [
            'sales' => $sales,
            'numOfSales' => $numOfSales,
            'chartDefault1' => $chartDefault1,
            'chartDefault2' => $chartDefault2,
            'chartDefault3' => $chartDefault3,
            'chartLive1' => $chartLive1,
            'chartLive2' => $chartLive2,
            'chartLive3' => $chartLive3,
            'chartTrouble1' => $chartTrouble1,
            'chartTrouble2' => $chartTrouble2,
            'chartTrouble3' => $chartTrouble3,
            'chartTelling1' => $chartTelling1,
            'chartTelling2' => $chartTelling2,
            'chartTelling3' => $chartTelling3,
            'new_students' => $newStudents->count(),
            'registered_students' => $registeredStudents->count(),
            'new_teachers' => $newTeachers->count(),
            'registered_teachers' => $registeredTeachers->count(),
            'page_views' => [
                'view_count' => $pageViews->sum('view_count'),
                'is_skills' => $pageViews->sum('is_skills'),
                'is_consultation' => $pageViews->sum('is_consultation'),
                'is_fortunetelling' => $pageViews->sum('is_fortunetelling'),
            ],
            'list_page_views' => $pageViews,
            'total_cancellation_students' => $totalCancellationStudents,
            'total_cancellation_teachers' => $totalCancellationTeachers,
            'day_of_month' => now()->parse($date['end_date'])->endOfDay()->diffInDays(now()->parse($date['start_date']))
        ];
    }
}
