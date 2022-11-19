<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ApplicantRepository.
 */
interface ApplicantRepository extends RepositoryInterface
{
    /**
     * Get Student Cancellation Count.
     *
     * @param $request
     * @return mixed
     */
    public function getStudentCancellationCount($request);

    /**
     * Get count of applicants.
     *
     * @param $request
     * @param mixed $courseId
     * @return mixed
     */
    public function getDataCountByCourseId($courseId);

    /**
     * Get Teacher Repeat Count.
     *
     * @param $studentId
     * @param $teacherId
     * @return mixed
     */
    public function getTeacherRepeatCount($studentId, $teacherId);

    /**
     * Get last purchase date.
     *
     * @param $studentId
     * @param $teacherId
     * @return mixed
     */
    public function getLastPurchaseDate($studentId, $teacherId);

    /**
     * Count Applicant By UserId.
     *
     * @param $userId
     * @return mixed
     */
    public function countApplicantByUserId($userId);

    /**
     * Count Teacher By UserId.
     *
     * @param $userId
     * @param $teacher
     * @return mixed
     */
    public function countTeacherByUserId($userId, $teacher);

    /**
     * Count holding result.
     *
     * @param $userId
     * @return mixed
     */
    public function countHoldingResult($userId);

    /**
     * Get user has already purchased course.
     *
     * @param array $data
     * @param $userId
     * @return mixed
     */
    public function getUserHasAlreadyPurchasedCourse(array $data, $userId);

    /**
     * Get student's cancellation count.
     *
     * @param $request
     * @param $data
     * @return mixed
     */
    public function getCountStudentCancellation($request, $data);

    /**
     * Get Applicant With CourseSchedule.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getApplicantWithCourseSchedule($courseScheduleId);

    /**
     * Get data for cancel applicant.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getApplicant($courseScheduleId);

    /**
     * Get List Applicant.
     *
     * @param $data
     * @return mixed
     */
    public function getListApplicant($data);

    /**
     * Get Count Applicant.
     *
     * @param $courseId
     * @return mixed
     */
    public function getCountApplicant($courseId);

    /**
     * Update cancel order confirm.
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function cancelOrderConfirm($courseScheduleId);

    /**
     * Get users pay course schedule.
     *
     * @return mixed
     */
    public function getUserPayCourseSchedule();

}
