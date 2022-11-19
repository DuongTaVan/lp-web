<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Services\Portal\CategoryService;

class CategoryController extends Controller
{
    /**
     * Get list category by type
     *
     * @param $type
     * @param CategoryService $service
     * @return \Illuminate\View\View|mixed
     */
    public function getListCategoryByType($type, CategoryService $service)
    {
        $data = $service->getListCategoryByType($type);
        return response()->json($data);
    }
}
