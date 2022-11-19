<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ImagePathRepository.
 *
 * @package namespace App\Repositories;
 */
interface ImagePathRepository extends RepositoryInterface
{
    /**
     * Get identity verification image list.
     *
     * @param $request
     * @return mixed
     */
    public function getIdentityVerificationImage($request);

    /**
     * @param $file
     * @param $userId
     * @param $path
     * @param $type
     * @return mixed
     */
    public function uploadUserImage($file, $userId, $path, $type);

    /**
     * @param $file
     * @param $userId
     * @param $path
     * @param $type
     * @param $displayOrder
     * @return mixed
     */
    public function uploadOrCreateUserImage($file, $userId, $path, $type, $displayOrder, $status = null);

    /**
     * @param $userId
     * @return mixed
     */
    public function getCourseImages($userId);

    /**
     * Remove image.
     *
     * @param $userId
     * @return mixed
     */
    public function removeImage($userId);

    /**
     * Remove image course.
     *
     * @param $courseId
     * @return mixed
     */
    public function removeImageCourse($courseId);

    /**
     * Count identity not verification image.
     *
     * @return mixed
     */
    public function countIdentityNotVerificationImage();

    /**
     * Business not verification image.
     *
     * @return mixed
     */
    public function businessNotVerificationImage();

    /**
     * Remove image qualification.
     *
     * @param $userId
     * @return mixed
     */
    public function removeImageQualification($userId);
}
