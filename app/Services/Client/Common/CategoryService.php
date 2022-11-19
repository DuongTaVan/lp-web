<?php

namespace App\Services\Client\Common;

use App\Repositories\CategoryRepositoryEloquent;
use App\Services\BaseService;

class CategoryService extends BaseService
{
    public function repository()
    {
        return CategoryRepositoryEloquent::class;
    }

    public function getCategories($type)
    {
        return $this->repository->getCategoriesByType($type);
    }
}
