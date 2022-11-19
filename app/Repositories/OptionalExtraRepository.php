<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OptionalExtraRepository.
 *
 * @package namespace App\Repositories;
 */
interface OptionalExtraRepository extends RepositoryInterface
{
    /**
     * Get optional extra
     *
     * @param array $data
     * @return mixed
     */
    public function getOptionalExtra(array $data);

    /**
     * Get optional extra
     *
     * @param $courseId
     * @return mixed
     */
    public function getOptionExtraPreview($courseId);
}
