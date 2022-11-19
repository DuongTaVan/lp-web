<?php

namespace App\Services\Portal;

use App\Repositories\SaleRepository;

class SaleService extends BaseService
{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository(): string
    {
        return SaleRepository::class;
    }

    /**
     * Get data to show on sales
     *
     * @param $request
     * @return array
     */
    public function getSalesData($request): array
    {
        // 1-1 Get the target months.
        $sales = $this->repository->getData($request);
        $total['sum_course_extension'] = 0;
        $total['option_sales'] = 0;
        $total['question_sales'] = 0;
        $total['gift_sales'] = 0;
        $total['total_sales'] = 0;
        $total['sales_commissions'] = 0;
        $total['system_commissions'] = 0;
        $total['cancellation_fee'] = 0;
        $total['other_commissions'] = 0;
        $total['total_commissions'] = 0;
        $total['teacher_profit'] = 0;
        $total['total_applicants'] = 0;
        $total['total_minutes'] = 0;
        foreach ($sales as $sale) {
            $total['sum_course_extension'] += $sale->sum_course_extension;
            $total['option_sales'] += $sale->option_sales;
            $total['question_sales'] += $sale->question_sales;
            $total['gift_sales'] += $sale->gift_sales;
            $total['total_sales'] += $sale->total_sales;
            $total['sales_commissions'] += $sale->sales_commissions;
            $total['system_commissions'] += $sale->system_commissions;
            $total['cancellation_fee'] += $sale->cancellation_fee;
            $total['other_commissions'] += $sale->other_commissions;
            $total['total_commissions'] += $sale->total_commissions;
            $total['teacher_profit'] += $sale->teacher_profit;
            $total['total_applicants'] += $sale->total_applicants;
            $total['total_minutes'] += $sale->total_minutes;
        }
        return [
            'sales' => $sales,
            'total' => $total
        ];
    }
}
