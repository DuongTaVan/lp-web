<?php

namespace App\Services\Client\Student;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Enums\ErrorType;
use App\Mail\AutoCancelCourseToStudent;
use App\Mail\AutoCancelCourseToTeacher;
use App\Mail\ConfirmCourseSchedule;
use App\Mail\TestMail;
use App\Mail\StudentCancel;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\ImagePathRepository;
use App\Repositories\QuestionTicketRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use App\Services\Client\Teacher\TeacherService;
use App\Traits\CourseImageTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CourseScheduleService extends BaseService
{
    use CourseImageTrait;
    private $questionTicketRepository;
    private $firebaseService;
    private $imagePathRepository;
    private $courseRepository;
    private $courseScheduleRepository;
    private $userRepository;
    private $applicantRepository;
    private $teacherService;

    public function __construct()
    {
        parent::__construct();
        $this->questionTicketRepository = app(QuestionTicketRepository::class);
        $this->firebaseService = app(FirebaseService::class);
        $this->imagePathRepository = app(ImagePathRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->teacherService = app(TeacherService::class);
    }

    public function repository()
    {
        return CourseScheduleRepository::class;
    }

    /**
     * Get course.
     *
     * @param int $id
     * @return mixed
     */
    public function getDetail(int $id)
    {
        $courseSchedule = $this->repository
            ->with(['course' => function ($query) {
                $query->where('is_archived', '=', DBConstant::NOT_ARCHIVED_FLAG)->with(['category', 'user']);
            }])
            ->with(['purchases' => function ($query) {
                $query->where('user_id', auth('client')->id())
                    ->whereIn('status', [
                        DBConstant::PURCHASES_STATUS_CAPTURED,
                        DBConstant::PURCHASES_STATUS_CANCELED_AFTER_CAPTURE
                    ]);
            }])
            ->findWhere([
                'course_schedule_id' => $id,
            ])
            ->first();
        if (!$courseSchedule) {
            return null;
        }
        $courseSchedule->parent_course_id = $courseSchedule->course->parent_course_id;
        $this->getImageOfSchedule($courseSchedule);

        return $courseSchedule;
    }

    /**
     * Get extend course.
     *
     * @param int $id
     * @return mixed
     */
    public function getExtend(int $id)
    {
        return $this->repository
            ->orderBy('end_datetime', 'DESC')
            ->findWhere([
                'parent_course_schedule_id' => $id,
                'type' => DBConstant::COURSE_SCHEDULES_TYPE_EXTENSION,
                'status' => DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
            ])
            ->first();
    }

    /**
     * Get question ticket.
     *
     * @param int $id
     * @return mixed
     */
    public function getQuestionTicket(int $id)
    {
        return $this->questionTicketRepository
            ->where([
                'user_id' => Auth()->guard('client')->id(),
                'course_schedule_id' => $id,
                'status' => DBConstant::UNUSED_STATUS
            ])
            ->first();
    }

    /**
     * Get question ticket.
     *
     * @param int $id
     * @param string|null $message
     * @param int|null $courseScheduleId
     * @param bool $forceSend
     * @return mixed
     */
    public function useQuestionTicket(string $message = null, int $courseScheduleId = null, $forceSend = false)
    {
        if ($message && $courseScheduleId) {
            $check = $this->firebaseService->sendLiveStreamComment($courseScheduleId, $message, $forceSend);
            if (!$check) {
                return response()->json([
                    'success' => false
                ], ErrorType::STATUS_4290);
            }
        }
        return [
            'success' => true
        ];
    }

    public function useQuestionTicketStamp(int $id, string $message = null, int $courseScheduleId = null, $forceSend = false)
    {
        if ($message && $courseScheduleId) {
            $check = $this->firebaseService->sendLiveStreamComment($courseScheduleId, $message, $forceSend);
            if (!$check) {
                return response()->json([
                    'success' => false
                ], ErrorType::STATUS_4290);
            }
        }
        $this->questionTicketRepository
            ->where([
                'user_id' => Auth()->guard('client')->id(),
                'question_ticket_id' => $id,
                'status' => DBConstant::UNUSED_STATUS
            ])
            ->update(['status' => DBConstant::USED_STATUS]);
        return [
            'success' => true
        ];
    }

    /**
     * Get sub course detail
     *
     * @param $courseId
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getSubCourseDetail($courseId)
    {
        return $this->courseRepository
            ->rightJoin('course_schedules as cs', 'cs.course_id', '=', 'courses.course_id')
            ->where([
                'courses.type' => DBConstant::COURSE_TYPE_SUB,
                'courses.parent_course_id' => $courseId,
                ['cs.purchase_deadline', '>=', Carbon::now()],
                'cs.type' => DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION,
                'cs.status' => DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                'courses.is_archived' => DBConstant::NOT_ARCHIVED_FLAG,
            ])
            ->first();
    }

    /**
     * Remind confirm course schedule.
     *
     * @return void
     */
    public function remindConFirmCourseSchedule()
    {
        $users = $this->applicantRepository->getUserPayCourseSchedule();
        if (count($users) > 0) {
            foreach ($users as $user) {
                $courseSchedules = $this->courseScheduleRepository->getCourseScheduleUpcoming($user['user_id'])->toArray();
                if (count($courseSchedules) > 0) {
                    $userProfile = $this->userRepository->find($user['user_id']);
                    Mail::to($userProfile->email)->queue(
                        new ConfirmCourseSchedule(
                            '【Lappi】開催日のご連絡',
                            $userProfile->full_name,
                            $courseSchedules
                        ));
                }
            }

        }

    }

    /**
     * Auto cancel course schedule when teacher join later > 10 minute.
     *
     * @return bool
     */
    public function autoCancelCourseSchedule()
    {
        //Get course schedule can cancel .
        $courseSchedules = $this->courseScheduleRepository
            ->where('start_datetime', '<', Carbon::now()->subMinutes(Constant::TIME_TEACHER_JOIN_LATE))
            ->where('status', Constant::COURSE_SCHEDULE_STATUS_OPEN)
            ->whereNull('canceled_at')
            ->whereNull('actual_start_date')
            ->get();

        if ($courseSchedules->count() > 0) {
            foreach ($courseSchedules as $courseSchedule) {
                /*
                 * If no one has purchased the course yet, update the status = null
                 * If the course has been purchased, refund and update status = null
                 */
                if ($courseSchedule->num_of_applicants > 0) {
                    $this->teacherService->cancelAfterCapture($courseSchedule);
                    $purchases = $courseSchedule->purchases;
                    if ($purchases->count() > 0) {
                        foreach ($purchases as $purchase) {
                            Mail::to($purchase->user->email)->queue(new AutoCancelCourseToStudent('【Lappi】自動キャンセルのお知らせ', $purchase->user->full_name, $courseSchedule, $courseSchedule->course->user->full_name));
                        }
                    }
                } else {
                    $courseSchedule->update([
                        'status' => DBConstant::COURSE_SCHEDULES_STATUS_CANCELED,
                        'canceled_at' => now()->format('Y-m-d H:i:s')
                    ]);
                }

                // change type room
                $this->firebaseService->updateStatusRoomCourse($courseSchedule->course_schedule_id, DBConstant::ROOM_TYPE_CLOSE, DBConstant::ROOM_STATUS_TEACHER_CANCEL);
            }
        }
        return true;
    }

    public function testMail()
    {
        Mail::to('anhltv@fabbi.com.vn')->queue(
            new TestMail(
                '【Lappi】開催日のご連絡',
                '$userProfile->full_name',
                '$courseSchedules'
            ));
    }
}
