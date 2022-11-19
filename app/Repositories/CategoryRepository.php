<?php

declare(strict_types=1);

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface CategoryRepository.
 */
interface CategoryRepository extends RepositoryInterface
{
    /**
     * Get all categories.
     *
     * @return mixed
     */
    public function getCategories();

    /**
     * Get category by type
     *
     * @param $type
     * @return mixed
     */
    public function getCategoriesByType($type);
}
