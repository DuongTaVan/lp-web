<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OptionalExtraMappingRepository.
 *
 * @package namespace App\Repositories;
 */
interface OptionalExtraMappingRepository extends RepositoryInterface
{
    /**
     * Get Option Data
     *
     * @param $courseScheduleId
     * @return mixed
     */
    public function getOptionData($courseScheduleId);
}
