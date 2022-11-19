<?php

declare(strict_types=1);

namespace App\Services\Batch;

use App\Enums\DBConstant;
use App\Repositories\CategoryRepository;
use App\Repositories\SaleRepository;
use App\Repositories\StatisticRepositoryEloquent;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class StatisticsService extends BaseService
{
    public $categoryRepository;
    public $saleRepository;

    /**
     * StatisticsService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->categoryRepository = app(CategoryRepository::class);
        $this->saleRepository = app(SaleRepository::class);
    }

    /**
     * @return string
     */
    public function repository()
    {
        return StatisticRepositoryEloquent::class;
    }

    /**
     * Create statistics.
     *
     * @return array
     */
    public function createStatistics(): array
    {
        // 1-1)	Get all the genres.
        $categoryIds = $this->categoryRepository->getCategories();

        // 1-2)	Loop as many times as the number of data at 1-1).
        foreach ($categoryIds as $categoryId) {
            // 1-2-1) Get total sales of the category.
            $totalSales = $this->saleRepository->getTotalSales($categoryId);

            // 1-2-2) Get the statistics data of 366 days ago.
            $statistics = $this->repository->getDataOfStatistics($categoryId);

            $data = [
                'categoryId' => $categoryId,
                'totalSales' => $totalSales,
                'statistics' => $statistics,
            ];

            // 1-2-3) Start transaction
            DB::beginTransaction();

            try {
                // 1-2-4) Create statistics.
                $this->repository->insertStatistics($data);

                // 1-2-5) Update sales status
                $this->saleRepository->updateSales($categoryId);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();

                return [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
            }
        }

        return ['success' => true];
    }

    public function updateStatistics()
    {
        $now = now();
        $minDate = $this->saleRepository
            ->where([
                'is_imported' => DBConstant::SALE_NOT_IMPORTED
            ])
            ->join('course_schedules as cs', 'sales.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as c', 'cs.course_id', '=', 'c.course_id')
            ->min('target_date');
        now()->setTestNow($minDate);
        $day = 0;
        while (now()->lt(now()->parse($now)->subDay())) {
            $day++;
            now()->setTestNow(now()->parse($minDate)->addDays($day));
            $this->createStatistics();
        }
    }
}
