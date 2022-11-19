<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Category;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryRepositoryEloquent.
 */
class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get all categories.
     *
     * @return mixed
     */
    public function getCategories()
    {
        return $this->model->orderBy('category_id', Constant::ORDER_BY_ASC)->pluck('category_id');
    }

    /**
     * Get category by type
     *
     * @param $type
     * @return mixed|void
     */
    public function getCategoriesByType($type)
    {
        return $this->model->where('type', $type)->get();
    }

    public function getCategoryLiveStream()
    {
        return $this->model->where('type', DBConstant::TYPE_CATEGORY_LIVESTREAM)->get();
    }
}
