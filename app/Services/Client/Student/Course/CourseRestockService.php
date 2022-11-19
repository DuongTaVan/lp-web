<?php

namespace App\Services\Client\Student\Course;

use App\Enums\DBConstant;
use App\Mail\RestockStudent;
use App\Mail\RestockTeacher;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\RestockRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CourseRestockService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $courseRepository;
    public $userRepository;
    public $courseScheduleRepository;

    /**
     * CourseReviewService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->courseRepository = app(CourseRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
    }

    /**
     * Review repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return RestockRepository::class;
    }

    /**
     * Post review
     *
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function postRestock($request)
    {
        $courseId = $request->course_id;
        $courseScheduleId = $request->course_schedule_id;
        $userId = Auth('client')->id();

        // 1,1) check request restock exist
        $restockData = $this->getRestock($userId, $courseId);
        if ($restockData) {
            return response([
                'status' => false,
                'message' => '開催リクエスト済みのため、再リクエストできません。'
            ]);
        }

        DB::beginTransaction();
        try {
            $this->repository->create([
                'user_id' => $userId,
                'course_id' => $courseId,
                'status' => DBConstant::STATUS_NOT_RESTOCK
            ]);
            //count user restock .
            $countUserRestock = $this->getAllRequestRestock($courseId);
            //get course and user .
            $courseUser = $this->courseRepository->where('course_id', $courseId)->with('user')->select('course_id', 'title', 'user_id')->first();
            // send mail restock
            Mail::to($courseUser->user->email)->queue(
                new RestockTeacher(
                    '【Lappi】開催リクエストがありました。',
                    $courseUser,
                    $courseUser->user->full_name,
                    $countUserRestock,
                    $courseScheduleId
                ));


            DB::commit();

            return response([
                'status' => true,
                'message' => '開催リクエストをしました。'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return response([
                'status' => false,
                'message' => '開催リクエスト済みのため、再リクエストできません。'
            ]);
        }
    }

    /**
     * get request restock course
     *
     * @param int $userId
     * @param int $courseId
     * @return mixed
     */
    public function getRestock(int $userId, int $courseId)
    {
        return $this->repository->where([
            'user_id' => $userId,
            'course_id' => $courseId,
            'status' => DBConstant::STATUS_NOT_RESTOCK
        ])->first();
    }

    /**
     * get request restock course
     *
     * @param int $courseId
     * @return mixed
     */
    public function getAllRequestRestock(int $courseId)
    {
        return $this->repository->where([
            'course_id' => $courseId,
            'status' => DBConstant::STATUS_NOT_RESTOCK
        ])->get();
    }

    /**
     * restock course
     *
     * @pararm int $courseId
     */
    public function restockCourse($courseIdParent, $courseId)
    {
        $arraySearch = [];
        if ($courseIdParent) {
            $arraySearch[] = $courseIdParent;
        }
        if ($courseId) {
            $arraySearch[] = $courseId;
        }
        //Get course schedule.
        $courseSchedule = $this->courseScheduleRepository
            ->whereIn('course_id', $arraySearch)
            ->orderBy('course_schedule_id', 'DESC')
            ->first();
        if (!$courseSchedule) {
            return;
        }
        $courseSchedule = $courseSchedule->toArray();
        if (count($courseSchedule) > 0) {
            //Get user_id .
            $userRestocks = $this->repository->where([
                'course_id' => $courseIdParent ?? $courseId,
                'status' => DBConstant::STATUS_NOT_RESTOCK
            ])->get();
            foreach ($userRestocks as $userRestock) {
                $user = $this->userRepository->find($userRestock->user_id);

                // send mail student restock
                Mail::to($user->email)->queue(
                    new RestockStudent(
                        '【Lappi】サービスが公開されました。',
                        $courseSchedule,
                        $user->full_name
                    ));
            }
        }

        $this->repository->where([
            'course_id' => $courseId,
            'status' => DBConstant::STATUS_NOT_RESTOCK
        ])->update([
            'status' => DBConstant::STATUS_HAD_RESTOCK
        ]);
    }
}
