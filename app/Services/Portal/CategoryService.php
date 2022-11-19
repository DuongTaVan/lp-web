<?php

namespace App\Services\Portal;

use App\Enums\DBConstant;
use App\Repositories\CategoryRepository;

class CategoryService extends BaseService

{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return CategoryRepository::class;
    }

    /**
     * Get list category by type
     *
     * @param $type
     * @return array
     */
    public function getListCategoryByType($type): array
    {
        if ((int)$type === 0) {
            $type = DBConstant::ALL_CATEGORY;
        } else {
            $type = [(int)$type];
        }
        $categories = $this->repository->whereIn('type', $type)->get();
        return [
            'categories' => $categories,
        ];
    }
}
