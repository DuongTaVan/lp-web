<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ReviewRepository.
 */
interface ReviewRepository extends RepositoryInterface
{
    /**
     * Get list review.
     *
     * @param array $data
     * @return mixed
     */
    public function listReview(array $data);

    /**
     * Get list review of teacher.
     *
     * @param $perPage
     * @param $id
     * @return mixed
     */
    public function listReviewOfTeacher($perPage, $id);

    /**
     * Get Avg Rating.
     *
     * @return mixed
     */
    public function getAvgRating();

    /**
     * Get Avg Rating By Target Date.
     *
     * @param $periodDaysStandard
     * @return mixed
     */
    public function getAvgRatingByTargetDate($periodDaysStandard);


    /**
     * Get Avg Rating coures schedule by id.
     *
     * @return mixed|void
     * @param $id
     */

    public function getRatingCourseScheduleById($userId);

    /**
     * Get Review Data.
     *
     * @param $courseId
     * @return mixed
     */
    public function getReviewData($courseId);

    public function saleHistoryReview($courseScheduleId, $request);
}
