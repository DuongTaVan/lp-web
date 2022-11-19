<?php

declare(strict_types=1);

namespace App\Services\Batch;

use App\Enums\DBConstant;
use App\Mail\CourseScheduleEnd;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepositoryEloquent;
use App\Repositories\PurchaseRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use Carbon\Carbon;
use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CourseScheduleService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $userRepository;
    public $purchaseRepository;
    public $courseRepository;
    public $firebaseService;

    /**
     * CourseReviewService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->userRepository = app(UserRepository::class);
        $this->purchaseRepository = app(PurchaseRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->firebaseService = app(FirebaseService::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return CourseScheduleRepositoryEloquent::class;
    }

    /**
     * Change course schedule.
     *
     * @return bool[]
     */
    public function changeCourseSchedule()
    {
        $courseSchedule = $this->repository->getCourseScheduleData();

        if (count($courseSchedule) > 0) {
            foreach ($courseSchedule as $course) {
                $coursesExtended = $this->repository->getCourseScheduleExtended($course->course_schedule_id);

                if (!empty($coursesExtended)) {
                    continue;
                }

                $attributes = [
                    'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
                ];
                $this->repository->update($attributes, $course->course_schedule_id);
                // CourseScheduleEnd.php
                $this->sendEmailEndCourseSchedule($course->course_schedule_id);

                // close all courseSchedule firebase
                $this->firebaseService->updateStatusRoomCourse($course->course_schedule_id, DBConstant::ROOM_TYPE_CLOSE, null);
            }
        }

        //Get all course consultation and fortunetelling.
        $courses = $this->courseRepository->getCourseVideoCall();
        if ($courses->count() > 0) {
            /**
             * Retrieve all the courses that are no longer open from the course.
             * Then update the status of its course extensions (is_hidden = 1).
             */
            foreach ($courses as $course) {
                if ((int)$course->course_schedules_open_and_draft_count === 0) {
                    DB::transaction(function () use ($course) {
                        $this->courseRepository->where([
                            'parent_course_id' => $course->course_id,
                            'type' => DBConstant::COURSE_TYPE_EXTENSION,
                            'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
                        ])->update(['is_hidden' => DBConstant::COURSE_IS_HIDDEN_CLOSE]);
                    }, 5);
                }
            }
        }
        return ['success' => true];
    }

    public function getCourseSchedule($courseScheduleId)
    {
        return $this->repository->find($courseScheduleId);
    }

    /**
     * Email end course schedules .
     *
     * @param int $courseScheduleId
     */
    public function sendEmailEndCourseSchedule(int $courseScheduleId)
    {
        $users = $this->purchaseRepository->getUserPayCourseScheduleSuccess($courseScheduleId);
        $courseSchedule = $this->repository->find($courseScheduleId);
        $subCourse = null;
        if ($courseSchedule->course->category) {
            if ($courseSchedule->course->user->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS) {
                $subCourse = $this->courseRepository->rightJoin('course_schedules as cs', 'cs.course_id', '=', 'courses.course_id')
                    ->where([
                        'courses.type' => DBConstant::COURSE_TYPE_SUB,
                        'courses.parent_course_id' => $courseSchedule->course->course_id,
                        ['cs.purchase_deadline', '>=', Carbon::now()],
                        'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                        'cs.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                        'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
                    ])
                    ->select('courses.*', 'courses.title as title_course', 'cs.*')
                    ->get();
                if ($subCourse->count() === 0) {
                    $subCourse = null;
                } else {
                    $subCourse = $subCourse->toArray();
                }
            }

        }
        foreach ($users as $key => $user) {
            $data = [
                'username' => $user->user->full_name ?? null,
                'title' => $courseSchedule->title,
                'price' => $courseSchedule->price,
                'date' => now()->parse($courseSchedule->start_datetime)->format('m月d日'),
                'time' => $courseSchedule->hour_minute,
                'subCourse' => $subCourse,
                'courseScheduleId' => $courseScheduleId
            ];
            \Log::info('Check data thanks mail ' . $key . ':  courseScheduleId: ' . $courseScheduleId . ' && user_id: ' . $user->user->user_id);

            Mail::to($user->user->email)->queue(
                new CourseScheduleEnd(
                    '【Lappi】本日はご利用ありがとうございました。',
                    config('app.url'),
                    $data
                ));
        }
    }

    public function checkPurchaseCourseSchedule($courseScheduleId, $studentId)
    {
        return $this->repository->checkPurchaseCourseSchedule($courseScheduleId, $studentId);
    }


}
