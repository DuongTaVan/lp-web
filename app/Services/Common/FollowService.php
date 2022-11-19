<?php

declare(strict_types=1);

namespace App\Services\Common;

use App\Enums\DBConstant;
use App\Repositories\ApplicantRepository;
use App\Repositories\FollowRepositoryEloquent;
use App\Services\BaseService;

class FollowService extends BaseService
{
    public $applicantRepository;

    /**
     * FollowService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->applicantRepository = app(ApplicantRepository::class);
    }

    /**
     * Follow repository class.
     *
     * @return string
     */
    public function repository()
    {
        return FollowRepositoryEloquent::class;
    }

    /**
     * Update follow.
     *
     * @param int $studentId
     * @param int $teacherId
     * @return array
     */
    public function updateFollow(int $studentId, int $teacherId)
    {
        $followed = $this->repository->findWhere([
            'from_user_id' => $studentId,
            'to_user_id' => $teacherId
        ])->first();

        // Check if the user has already followed the teacher
        if (!$followed) {
            return [
                'success' => false,
                'message' => __('message.not_follow_teacher'),
            ];
        }

        // Update follow.
        $teacherRepeatCount = $this->applicantRepository->getTeacherRepeatCount($studentId, $teacherId);

        $lastPurchasedAt = $this->applicantRepository->getLastPurchaseDate($studentId, $teacherId);

        $attributes = [
            'teacher_repeat_count' => $teacherRepeatCount['teacher_repeat_count'] ?? DBConstant::TEACHER_REPEAT_COUNT_DEFAULT,
            'last_purchased_at' => $lastPurchasedAt['created_at'] ?? null,
        ];
        $followed->update($attributes);

        return ['success' => true];
    }
}
