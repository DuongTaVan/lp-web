<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface PageViewRepository.
 */
interface PageViewRepository extends RepositoryInterface
{
    /**
     * Get Sum Page View.
     *
     * @param $request
     * @return mixed
     */
    public function getSumPageView($request);

    /**
     * Get sum page view teacher.
     *
     * @param $data
     * @return mixed
     */
    public function getSumTeacherPageView($data);

    /**
     * Get Sum View Count.
     *
     * @return mixed
     */
    public function getSumViewCount();
}
