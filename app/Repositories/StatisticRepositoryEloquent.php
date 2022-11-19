<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Statistic;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class StatisticRepositoryEloquent.
 */
class StatisticRepositoryEloquent extends BaseRepository implements StatisticRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Statistic::class;
    }

    /**
     * Get Sum Data To Show On Statistics.
     *
     * @param $request
     * @return mixed
     */
    public function getSumData($request)
    {
        // Set variable
        $sortColumn = $request->input('sort_column', Constant::STATISTIC_SORT_BY_DEFAULT);
        $sortType = $request->input('sort_by', Constant::ORDER_BY_ASC);

        $query = $this->selectSumByRangeDate($request)
            ->selectRaw('target_date')
            // ->orderBy('target_date', 'asc')
            ->groupBy('target_date');

        return $query->orderBy($sortColumn, $sortType)->get()->toArray();
    }

    /**
     * Get Sum Data To Show On Term Statistics.
     *
     * @param $request
     * @return mixed
     */
    public function getSumDataByTerm($request)
    {
        // Set variable
        $term = (int)$request->term;

        // 1-1) Get the target months.
        $targetMonth = Constant::ARRAY_PERIOD_1;

        if ($term === Constant::PERIOD_2) {
            $targetMonth = Constant::ARRAY_PERIOD_2;
        }

        $statistics = [];
        $amountTransferred = [];
        $amountNotTransferred = [];
        foreach ($targetMonth as $month) {
            $year = $request->year ?? now()->year;

            if ($month < Constant::BEGINNING_OF_SEMESTER_1) {
                ++$year;
            }

//            else if ($month >= Constant::BEGINNING_OF_SEMESTER_1 && now()->month <= Constant::BEGINNING_OF_SEMESTER_1) {
//                $year = $year;
//            }
            $startDate = now()->setMonth($month)->setYear($year)->firstOfMonth()->startOfDay();
            $endDate = now()->setMonth($month)->setYear($year)->lastOfMonth()->endOfDay();
            $startSubDate = now()->setMonth($month)->setYear($year)->subYear(1)->firstOfMonth()->startOfDay()->format('Y-m-d H:i:s');
//            $endSubDate = now()->setMonth($month)->setYear($year)->subYear(1)->lastOfMonth()->endOfDay();
            $request->merge([
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);

            $query = $this->selectSumByRangeDate($request)->first()->toArray();

            $statistics[] = [
                'title' => $month . Constant::MONTH,
                'data' => $query
            ];
            $amountTransferredOfMonth = resolve(TransferHistoryRepository::class)->dataTransferAll($startDate->format('Y-m-d'));
            $amountTransferredOfMonthLy = resolve(TransferHistoryRepository::class)->dataTransferAll($startSubDate);

            $dataEndMonth = resolve(CashRepository::class)->getDataAllUserEndMonth($startDate->format('Y-m-d'));
            $payoutWaitingMonth = resolve(TransferHistoryRepository::class)->dataNotTransferAll($startDate->format('Y-m-d'));
            $amountNotTransferredOfMonth = (int)$dataEndMonth['balance'] + $payoutWaitingMonth;

            $dataEndMonthLy = resolve(CashRepository::class)->getDataAllUserEndMonth($startSubDate);
            $payoutWaitingMonthLy = resolve(TransferHistoryRepository::class)->dataNotTransferAll($startSubDate);
            $amountNotTransferredOfMonthLy = (int)$dataEndMonthLy['balance'] + $payoutWaitingMonthLy;
            $amountTransferred[] = [
                'title' => $month . Constant::MONTH,
                'data' => $amountTransferredOfMonth,
                'data_ly' => $amountTransferredOfMonthLy
            ];
            $amountNotTransferred[] = [
                'title' => $month . Constant::MONTH,
                'data' => $amountNotTransferredOfMonth > 0 ? $amountNotTransferredOfMonth / 1000 : 0,
                'data_ly' => $amountNotTransferredOfMonthLy > 0 ? $amountNotTransferredOfMonthLy / 1000 : 0
            ];
        }

        $sumArray = [];
        foreach ($statistics as $k => $subArray) {
            foreach ($subArray['data'] as $id => $value) {
                try {
                    $sumArray[$id] += $value;
                } catch (\Exception $e) {
                    $sumArray[$id] = $value;
                }
            }
        }

//        $sumArray['percent_total_sales'] = $this->percent($sumArray['total_sales'], $sumArray['total_sales_ly']);
        foreach ($sumArray as $k => $value) {
            if (str_contains($k, 'percent_')) {
                $key = substr($k, 8);

                switch (true) {
                    case array_key_exists('sum_' . $key, $sumArray):
                        $sumArray[$k] = $this->percent($sumArray['sum_' . $key], $sumArray['sum_' . $key . '_ly']);
                        break;
                    case array_key_exists('sub_' . $key, $sumArray):
                        $sumArray[$k] = $this->percent($sumArray['sub_' . $key], $sumArray['sub_' . $key . '_ly']);
                        break;
                    case array_key_exists('ratio_' . $key, $sumArray):
                        $sumArray[$k] = $this->percent($sumArray['ratio_' . $key], $sumArray['ratio_' . $key . '_ly']);
                        break;
                    default:
                        $sumArray[$k] = $this->percent($sumArray[$key], $sumArray[$key . '_ly']);
                        break;
                }
            }
        }

        $statistics[] = [
            'title' => '上半期計',
            'data' => $sumArray
        ];
        $totalAmountTransferred = 0;
        $totalAmountTransferredLy = 0;
        foreach ($amountTransferred as $at) {
            $totalAmountTransferred += $at['data'];
            $totalAmountTransferredLy += $at['data_ly'];
        }
        $amountTransferred[] = [
            'title' => '上半期計',
            'data' => $totalAmountTransferred,
            'data_ly' => $totalAmountTransferredLy
        ];
        $totalAmountNotTransferred = 0;
        $totalAmountNotTransferredLy = 0;
        foreach ($amountNotTransferred as $ant) {
            $totalAmountNotTransferred += $ant['data'];
            $totalAmountNotTransferredLy += $ant['data_ly'];
        }
        $amountNotTransferred[] = [
            'title' => '上半期計',
            'data' => $totalAmountNotTransferred,
            'data_ly' => $totalAmountNotTransferredLy
        ];

        $result = [
            'statistics' => $statistics,
            'amountTransferred' => $amountTransferred,
            'amountNotTransferred' => $amountNotTransferred
        ];

        return $result;
    }

    /**
     * Percent.
     *
     * @param float $numerator
     * @param float $denominator
     * @return float
     */
    private function percent(float $numerator, float $denominator): float
    {
        if (!$denominator) {
            return 0;
        }

        return floor($numerator / $denominator * 1000) / 10;
    }

    /**
     * Common get data sum by range date.
     *
     * @param $request
     * @return mixed
     */
    public function selectSumByRangeDate($request)
    {
        // get value from request
        $categoryType = $request->category_type;
        $categoryId = $request->category_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $year = $request->year;

        // Set select raw with Sum
        // calculator
        $sumOtherCommission = '(COALESCE(SUM(other_commissions), 0))';
        $sumOtherCommissionLy = '(COALESCE(SUM(other_commissions_ly), 0))';
        $percentTotalSales = 'TRUNCATE(COALESCE(SUM(total_sales), 0)/COALESCE(SUM(total_sales_ly), 0)*100, 1)';
        $sumCourseExtension = '(COALESCE(SUM(course_sales), 0)+COALESCE(SUM(extension_sales), 0))';
        $sumCourseExtensionLy = '(COALESCE(SUM(course_sales_ly), 0)+COALESCE(SUM(extension_sales_ly), 0))';
        $percentCourseExtension = 'TRUNCATE(' . $sumCourseExtension . '/' . $sumCourseExtensionLy . '*100, 1)';
        $sumQuestionGift = '(COALESCE(SUM(question_sales), 0)+COALESCE(SUM(gift_sales), 0))';
        $differenceTotalSales = '(COALESCE(SUM(total_sales), 0)-COALESCE(SUM(total_commissions), 0))';
        $differenceTotalSalesLy = '(COALESCE(SUM(total_sales_ly), 0)-COALESCE(SUM(total_commissions_ly), 0))';
        $percentOtherTotalSalesLy = 'TRUNCATE(' . $differenceTotalSales . '/' . $differenceTotalSalesLy . '*100, 1)';
        $sumQuestionGiftLy = '(COALESCE(SUM(question_sales_ly), 0)+COALESCE(SUM(gift_sales_ly), 0))';
        $coinDistribution = '(COALESCE(' . $sumQuestionGift . '-' . $sumOtherCommission . ', 0))';
        $coinDistributionLy = '(COALESCE(' . $sumQuestionGiftLy . '-' . $sumOtherCommissionLy . ', 0))';
        $percentCoinDistribution = 'TRUNCATE(' . $coinDistribution . '/' . $coinDistributionLy . '*100, 1)';
        $percentQuestionGift = 'TRUNCATE(' . $sumQuestionGift . '/' . $sumQuestionGiftLy . '*100, 1)';
        $percentOtherCommission = 'TRUNCATE(' . $sumOtherCommission . '/' . $sumOtherCommissionLy . '*100, 1)';
        $percentSaleCommission = 'TRUNCATE(COALESCE(SUM(sales_commissions), 0)/COALESCE(SUM(sales_commissions_ly), 0)*100, 1)';
        $percentOptionSales = 'TRUNCATE(COALESCE(SUM(option_sales), 0)/COALESCE(SUM(option_sales_ly), 0)*100, 1)';
        $percentTotalCommission = 'TRUNCATE(COALESCE(SUM(total_commissions), 0)/COALESCE(SUM(total_commissions_ly), 0)*100, 1)';
        $percentNumOfApplicants = 'TRUNCATE(COALESCE(SUM(num_of_applicants), 0)/COALESCE(SUM(num_of_applicants_ly), 0)*100, 1)';
        $ratioTotalSalesNumOfApplicants = '(COALESCE(SUM(total_sales)/1.1, 0)/COALESCE(SUM(num_of_applicants), 0))';
        $ratioTotalSalesNumOfApplicantsLy = '(COALESCE(SUM(total_sales_ly)/1.1, 0)/COALESCE(SUM(num_of_applicants_ly), 0))';
        $percentTotalSalesNumOfApplicants = 'TRUNCATE(' . $ratioTotalSalesNumOfApplicants . '/' . $ratioTotalSalesNumOfApplicantsLy . '*100 , 1)';
        $percentNumOfCourses = 'TRUNCATE(COALESCE(SUM(num_of_courses), 0)/COALESCE(SUM(num_of_courses_ly), 0)*100, 1)';
        $ratioTotalSalesNumOfCourses = '(COALESCE(SUM(total_sales)/1.1, 0)/COALESCE(SUM(num_of_courses), 0))';
        $ratioTotalSalesNumOfCoursesLy = '(COALESCE(SUM(total_sales_ly)/1.1, 0)/COALESCE(SUM(num_of_courses_ly), 0))';
        $percentTotalSalesNumOfCourses = 'TRUNCATE(' . $ratioTotalSalesNumOfCourses . '/' . $ratioTotalSalesNumOfCoursesLy . '*100 , 1)';
        $percentStreamingMinutes = 'TRUNCATE(COALESCE(SUM(streaming_minutes), 0)/COALESCE(SUM(streaming_minutes_ly), 0)*100, 1)';
        $percentCancellationFee = 'TRUNCATE(COALESCE(SUM(cancellation_fee), 0)/COALESCE(SUM(cancellation_fee_ly), 0)*100, 1)';
        $ratioStreamingMinutesNumOfCourses = '(COALESCE(SUM(streaming_minutes), 0)/COALESCE(SUM(num_of_courses), 0))';
        $ratioStreamingMinutesNumOfCoursesLy = '(COALESCE(SUM(streaming_minutes_ly), 0)/COALESCE(SUM(num_of_courses_ly), 0))';
        $percentStreamingMinutesNumOfCourses = 'TRUNCATE(' . $ratioStreamingMinutesNumOfCourses . '/' .
            $ratioStreamingMinutesNumOfCoursesLy . '*100 , 1)';
        $percentTeacherProfitEcxTax = 'TRUNCATE(COALESCE(SUM(teacher_profit_exc_tax), 0)/
            COALESCE(SUM(teacher_profit_exc_tax_ly), 0)*100, 1)';
        $percentSystemCommissions = 'TRUNCATE(COALESCE(SUM(system_commissions), 0)/COALESCE(SUM(system_commissions_ly), 0)*100, 1)';
        $selectSum = '
            COALESCE(SUM(total_sales), 0) as total_sales,
            COALESCE(SUM(total_sales_ly), 0) as total_sales_ly,
            COALESCE(' . $percentTotalSales . ', 0) as percent_total_sales,
            COALESCE(SUM(course_sales), 0) as course_sales,
            COALESCE(SUM(course_sales_ly), 0) as course_sales_ly,
            COALESCE(SUM(extension_sales), 0) as extension_sales,
            COALESCE(SUM(extension_sales_ly), 0) as extension_sales_ly,
            ' . $sumCourseExtension . ' as sum_course_extension,
            ' . $sumCourseExtensionLy . ' as sum_course_extension_ly,
            COALESCE(' . $percentCourseExtension . ', 0) as percent_course_extension,
            COALESCE(SUM(option_sales), 0) as option_sales,
            COALESCE(SUM(option_sales_ly), 0) as option_sales_ly,
            COALESCE(SUM(question_sales), 0) as question_sales,
            COALESCE(SUM(question_sales_ly), 0) as question_sales_ly,
            COALESCE(SUM(gift_sales), 0) as gift_sales,
            COALESCE(SUM(gift_sales_ly), 0) as gift_sales_ly,
            ' . $sumQuestionGift . ' as sum_question_gift,
            ' . $sumQuestionGiftLy . ' as sum_question_gift_ly,
            COALESCE(SUM(other_commissions), 0) as other_commissions,
            COALESCE(SUM(other_commissions_ly), 0) as other_commissions_ly,
            ' . $sumOtherCommission . ' as sum_other_commission,
            ' . $sumOtherCommissionLy . ' as sum_other_commission_ly,
            COALESCE(' . $percentOtherCommission . ', 0) as percent_other_commission,
            COALESCE(' . $percentQuestionGift . ', 0) as percent_question_gift,
            COALESCE(' . $percentOptionSales . ', 0) as percent_option_sales,
            COALESCE(SUM(sales_commissions), 0) as sales_commissions,
            COALESCE(SUM(sales_commissions_ly), 0) as sales_commissions_ly,
            ' . $percentSaleCommission . ' as percent_sales_commissions,
            COALESCE(SUM(total_commissions), 0) as total_commissions,
            COALESCE(SUM(total_commissions_ly), 0) as total_commissions_ly,
            COALESCE(' . $percentTotalCommission . ', 0) as percent_total_commissions,
            COALESCE(SUM(system_commissions), 0) as system_commissions,
            COALESCE(SUM(system_commissions_ly), 0) as system_commissions_ly,
            COALESCE(' . $percentSystemCommissions . ', 0) as percent_system_commissions,
            COALESCE(' . $percentOtherTotalSalesLy . ', 0) as percentOtherTotalSalesLy,
            COALESCE(SUM(num_of_applicants), 0) as num_of_applicants,
            COALESCE(SUM(num_of_applicants_ly), 0) as num_of_applicants_ly,
            COALESCE(' . $percentNumOfApplicants . ', 0) as percent_num_of_applicants,
            TRUNCATE(' . $ratioTotalSalesNumOfApplicants . ', 0) as ratio_total_sales_num_of_applicants,
            TRUNCATE(' . $ratioTotalSalesNumOfApplicantsLy . ', 0) as ratio_total_sales_num_of_applicants_ly,
            COALESCE(' . $percentTotalSalesNumOfApplicants . ', 0) as percent_total_sales_num_of_applicants,
            COALESCE(SUM(num_of_courses), 0) as num_of_courses,
            COALESCE(SUM(num_of_courses_ly), 0) as num_of_courses_ly,
            COALESCE(' . $percentNumOfCourses . ', 0) as percent_num_of_courses,
            TRUNCATE(' . $ratioTotalSalesNumOfCourses . ', 0) as ratio_total_sales_num_of_courses,
            TRUNCATE(' . $ratioTotalSalesNumOfCoursesLy . ', 0) as ratio_total_sales_num_of_courses_ly,
            COALESCE(' . $percentTotalSalesNumOfCourses . ', 0) as percent_total_sales_num_of_courses,
            COALESCE(SUM(streaming_minutes), 0) as streaming_minutes,
            COALESCE(SUM(streaming_minutes_ly), 0) as streaming_minutes_ly,
            COALESCE(' . $percentStreamingMinutes . ', 0) as percent_streaming_minutes,
            TRUNCATE(' . $ratioStreamingMinutesNumOfCourses . ', 0) as ratio_streaming_minutes_num_of_courses,
            TRUNCATE(' . $ratioStreamingMinutesNumOfCoursesLy . ', 0) as ratio_streaming_minutes_num_of_courses_ly,
            COALESCE(' . $percentStreamingMinutesNumOfCourses . ', 0) as percent_streaming_minutes_num_of_courses,
            COALESCE(SUM(teacher_profit_exc_tax), 0) as teacher_profit_exc_tax,
            COALESCE(SUM(teacher_profit_exc_tax_ly), 0) as teacher_profit_exc_tax_ly,
            COALESCE(' . $percentTeacherProfitEcxTax . ', 0) as percent_teacher_profit_exc_tax,
            COALESCE(SUM(cancellation_fee), 0) as cancellation_fee,
            COALESCE(SUM(cancellation_fee_ly), 0) as cancellation_fee_ly,
            COALESCE(' . $percentCancellationFee . ', 0) as percent_cancellation_fee,
            ' . $coinDistribution . ' as coin_distribution,
            ' . $coinDistributionLy . ' as coin_distribution_ly,
            ' . $percentCoinDistribution . ' as percent_coin_distribution
            ';

        $query = $this->selectRaw(
            $selectSum
        )->join(
            'categories as c',
            'statistics.category_id',
            '=',
            'c.category_id'
        )->where('statistics.target_date', '>=', now()->parse($startDate)->startOfDay());

        if ($endDate) {
            $query->where('statistics.target_date', '<=', now()->parse($endDate)->endOfDay());
        }
        if ($request->filled('category_type')) {
            if ((int)$categoryType === 0) {
                $categoryType = DBConstant::ALL_CATEGORY;
            } else {
                $categoryType = [$categoryType];
            }
            $query->whereIn('c.type', $categoryType);
        }

        if ($categoryId) {
            $query->where('c.category_id', '=', $categoryId);
        }

        return $query;
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Data Of Statistics.
     *
     * @param $categoryIds
     * @return mixed|void
     */
    public function getDataOfStatistics($categoryId)
    {
        $targetDate = now()->subDays(Constant::DAYS_AGO_366);

        return $this->model->whereDate('target_date', $targetDate)
            ->where(['category_id' => $categoryId])
            ->first();
    }

    /**
     * Insert statistics.
     *
     * @param $data
     * @return mixed|void
     */
    public function insertStatistics($data)
    {
        $values = [
            'category_id' => $data['categoryId'],
            'target_date' => now()->Yesterday(),
            '365_days_ago' => now()->subDays(Constant::DAYS_AGO_366),
            'total_sales' => $data['totalSales']['total_sales'] ?? 0,
            'total_sales_ly' => $data['statistics']['total_sales'] ?? null,
            'course_sales' => $data['totalSales']['course_sales'] ?? 0,
            'course_sales_ly' => $data['statistics']['course_sales'] ?? null,
            'extension_sales' => $data['totalSales']['extension_sales'] ?? 0,
            'extension_sales_ly' => $data['statistics']['extension_sales'] ?? null,
            'option_sales' => $data['totalSales']['option_sales'] ?? 0,
            'option_sales_ly' => $data['statistics']['option_sales'] ?? null,
            'question_sales' => $data['totalSales']['question_sales'] ?? 0,
            'question_sales_ly' => $data['statistics']['question_sales'] ?? null,
            'gift_sales' => $data['totalSales']['gift_sales'] ?? 0,
            'gift_sales_ly' => $data['statistics']['gift_sales'] ?? null,
            'sales_commissions' => $data['totalSales']['sales_commissions'] ?? 0,
            'sales_commissions_ly' => $data['statistics']['sales_commissions'] ?? null,
            'system_commissions' => $data['totalSales']['system_commissions'] ?? 0,
            'system_commissions_ly' => $data['statistics']['system_commissions'] ?? null,
            'total_commissions' => $data['totalSales']['total_commissions'] ?? 0,
            'total_commissions_ly' => $data['statistics']['total_commissions'] ?? null,
            'num_of_applicants' => $data['totalSales']['num_of_applicants'] ?? 0,
            'num_of_applicants_ly' => $data['statistics']['num_of_applicants'] ?? null,
            'num_of_courses' => $data['totalSales']['num_of_courses'] ?? 0,
            'num_of_courses_ly' => $data['statistics']['num_of_courses'] ?? null,
            'streaming_minutes' => $data['totalSales']['streaming_minutes'] ?? 0,
            'streaming_minutes_ly' => $data['statistics']['streaming_minutes'] ?? null,
            'teacher_profit_exc_tax' => $data['totalSales']['teacher_profit_exc_tax'] ?? 0,
            'other_commissions' => $data['totalSales']['other_commissions'] ?? 0,
            'other_commissions_ly' => $data['statistics']['other_commissions'] ?? 0,
            'teacher_profit_exc_tax_ly' => $data['statistics']['teacher_profit_exc_tax'] ?? null,
            'cancellation_fee' => $data['totalSales']['cancellation_fee'] ?? 0,
            'cancellation_fee_ly' => $data['statistics']['cancellation_fee'] ?? null
        ];
        $this->model->create($values);
    }
}
