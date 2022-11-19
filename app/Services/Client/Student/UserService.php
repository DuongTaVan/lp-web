<?php

namespace App\Services\Client\Student;

use App\Enums\DBConstant;
use App\Http\Requests\Client\Student\CloseAccountRequest;
use App\Mail\DeleteAccount;
use App\Repositories\ApplicantRepository;
use App\Repositories\CourseRepository;
use App\Repositories\CourseScheduleRepository;
use App\Repositories\FollowRepository;
use App\Repositories\SubscriberRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Services\Client\Common\FirebaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserService extends BaseService
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    public $applicantRepository;
    public $courseScheduleRepository;
    public $courseRepository;
    public $followRepository;
    public $subscriberRepository;
    private $firebaseService;

    /**
     * CourseReviewService constructor.
     */
    public function __construct()
    {
        // add repository
        parent::__construct();
        $this->applicantRepository = app(ApplicantRepository::class);
        $this->courseScheduleRepository = app(CourseScheduleRepository::class);
        $this->courseRepository = app(CourseRepository::class);
        $this->followRepository = app(FollowRepository::class);
        $this->subscriberRepository = app(SubscriberRepository::class);
        $this->firebaseService = app(FirebaseService::class);
    }

    /**
     * Review repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return UserRepository::class;
    }

    /**
     * close account.
     *
     * @param CloseAccountRequest $request
     * @return array
     */
    public function close(CloseAccountRequest $request): array
    {
        DB::beginTransaction();
        try {
            // set value
            $userId = auth('client')->id();
            $archiveReason = $request->get('archive_reason');
            $archiveReasonText = $request->get('archive_reason_text');

            // 1-1) Check if the user has course schedules which he will participate in.
            $applicants = $this->applicantRepository->getParticipateCourseSchedule($userId);

            if (count($applicants)) {
                return [
                    'status' => false,
                    'message' => __('errors.MSG_6029')
                ];
            }

            // 1-2) Check if cash balance is not negative.
            $user = $this->repository->where([
                'user_id' => $userId,
                'is_archived' => DBConstant::NOT_ARCHIVED_FLAG
            ])->first();
            if (!$user) {
                return [];
            }

            if ($user->cash_balance < 0) {
                return [
                    'status' => false,
                    'message' => __('errors.MSG_6030')
                ];
            }

            // 1-3)	Check if the user has open course schedules.
            $courseSchedule = $this->courseScheduleRepository->open($userId);

            if (count($courseSchedule)) {
                return [
                    'status' => false,
                    'message' => __('errors.MSG_6031')
                ];
            }

            // 1-4)	Archive all the courses.
            $this->courseRepository->where('user_id', '=', $userId)
                ->update(['is_archived' => DBConstant::ARCHIVED_FLAG]);

            // 1-5) Delete all the follows.
            $this->followRepository->where(
                'from_user_id', '=', $userId
            )->orWhere(
                'to_user_id', '=', $userId
            )->delete();

            // 1-6)	Delete all the subscribes.
            $this->subscriberRepository->where(
                'from_user_id', '=', $userId
            )->orWhere(
                'to_user_id', '=', $userId
            )->delete();

            // 1-7)	Archive the user.

            $user->is_archived = DBConstant::ARCHIVED_FLAG;
            $user->archive_reason = $archiveReason;
            $user->archive_reason_text = $archiveReasonText;
            $user->save();

            // remove all message
            $this->firebaseService->deleteRoomStudent($userId);
            $this->firebaseService->deleteRoomTeacher($userId);

            Mail::to($user->email)->queue(
                new DeleteAccount(
                    '【Lappi】退会手続き完了のお知らせ。',
                    $user->full_name
                ));

            \auth('client')->logout();
            DB::commit();

            return [
                'status' => true,
                'message' => 'Success'
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'status' => true,
                'message' => 'Success'
            ];
        }
    }
}
