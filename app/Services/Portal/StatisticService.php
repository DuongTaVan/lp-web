<?php

namespace App\Services\Portal;

use App\Http\Requests\Portal\TermStatisticRequest;
use App\Repositories\StatisticRepository;
use Carbon\Carbon;

class StatisticService extends BaseService
{
    /**
     * User repository class
     *
     * @return string
     */
    public function repository()
    {
        return StatisticRepository::class;
    }

    /**
     * Get data to show on statistics
     *
     * @param $request
     * @return array
     */
    public function getStatisticsData($request)
    {
        // 1-1 Show statistics.
        $statistic = $this->repository->getSumData($request);
        $total['total_sales'] = 0;
        $total['sum_course_extension'] = 0;
        $total['option_sales'] = 0;
        $total['sum_question_gift'] = 0;
        $total['sales_commissions'] = 0;
        $total['coin_distribution'] = 0;
        $total['other_commissions'] = 0;
        $total['total_commissions'] = 0;
        $total['num_of_applicants'] = 0;
        $total['ratio_total_sales_num_of_applicants'] = 0;
        $total['num_of_courses'] = 0;
        $total['ratio_total_sales_num_of_courses'] = 0;
        $total['ratio_streaming_minutes_num_of_courses'] = 0;
        $total['system_commissions'] = 0;
        $total['streaming_minutes'] = 0;
        $total['cancellation_fee'] = 0;
        $total['teacher_profit_exc_tax'] = 0;
        $total['total_record_have_time'] = 0;
        $weekMap = [
            0 => '日',
            1 => '月',
            2 => '火',
            3 => '水',
            4 => '木',
            5 => '金',
            6 => '土',
        ];
        $data = [];
        foreach ($statistic as $item) {
            $total['total_sales'] += ((int)$item['total_sales']);
            $total['sum_course_extension'] += ((int)$item['sum_course_extension']);
            $total['option_sales'] += ((int)$item['option_sales']);
            $total['sum_question_gift'] += ((int)$item['sum_question_gift']);
            $total['total_commissions'] += ((int)$item['total_commissions']);
            $total['sales_commissions'] += ((int)$item['sales_commissions']);
            $total['other_commissions'] += ((int)$item['other_commissions']);
            $total['coin_distribution'] += ((int)$item['coin_distribution']);
            $total['num_of_applicants'] += (int)($item['num_of_applicants']);
            $total['ratio_total_sales_num_of_applicants'] += (int)($item['ratio_total_sales_num_of_applicants']);
            $total['num_of_courses'] += (int)($item['num_of_courses']);
            $total['ratio_total_sales_num_of_courses'] += (int)($item['ratio_total_sales_num_of_courses']);
            $total['ratio_streaming_minutes_num_of_courses'] += (int)($item['ratio_streaming_minutes_num_of_courses']);
            $total['system_commissions'] += ((int)$item['system_commissions']);
            $total['streaming_minutes'] += (int)($item['streaming_minutes']);
            $total['cancellation_fee'] += (int)($item['cancellation_fee']);
            $total['teacher_profit_exc_tax'] += ((int)$item['teacher_profit_exc_tax']);
            $item['holiday'] = Carbon::parse($item['target_date'])->dayOfWeek == 0 || Carbon::parse($item['target_date'])->dayOfWeek == 6 ? true : false;
            $item['target_date'] = $item['target_date'] . ' ('.$weekMap[Carbon::parse($item['target_date'])->dayOfWeek].')';
            $data[] = $item;
            if ((int)($item['ratio_streaming_minutes_num_of_courses']) > 0) {
                $total['total_record_have_time'] += 1;
            }
        }

        return [
            'statistic' => $data,
            'total' => $total,
        ];
    }

    /**
     * Get data to show on term statistics
     *
     * @param TermStatisticRequest $request
     * @return array
     */
    public function getTermStatisticsData(TermStatisticRequest $request): array
    {
        $result = $this->repository->getSumDataByTerm($request);

        return [
            'statistic' => $result['statistics'],
            'amountTransferred' => $result['amountTransferred'],
            'amountNotTransferred' => $result['amountNotTransferred']
        ];
    }
}
