<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CourseRepository.
 */
interface CourseRepository extends RepositoryInterface
{
    /**
     * Get course video call
     * Get all course consultation and fortunetelling.
     *
     * @return mixed
     */
    public function getCourseVideoCall();
}
