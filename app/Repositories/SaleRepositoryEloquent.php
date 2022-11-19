<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Models\Cash;
use App\Models\Sale;
use App\Models\Statistic;
use App\Traits\EloquentTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class SaleRepositoryEloquent.
 */
class SaleRepositoryEloquent extends BaseRepository implements SaleRepository
{
    use EloquentTrait;

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Sale::class;
    }

    /**
     * Get Sum Data To Show On Dashboard.
     *
     * @param $request
     * @return mixed
     */
    public function getSumData($request)
    {
        // Set variable
        $category = $request->category;
        // $month = $request->month;

        $date = [
            'start_date' => $request->start_date ?? now()->firstOfMonth(),
            'end_date' => $request->end_date ?? now()
        ];
        // Set select raw with Sum
        $selectSum = 'SUM(is_skills) as is_skills,
            SUM(is_skills_sub) as is_skills_sub,
            COUNT(sales.id) as num_of_courses,
            SUM(is_consultation) as is_consultation,
            SUM(is_fortunetelling) as is_fortunetelling,
            SUM(total_minutes) as total_minutes,
            SUM(minutes_skills) as minutes_skills,
            SUM(minutes_skills_sub) as minutes_skills_sub,
            SUM(minutes_skills_sub_extended) as minutes_skills_sub_extended,
            SUM(skills_sub_extension_count) as skills_sub_extension_count,
            SUM(minutes_consultation) as minutes_consultation,
            SUM(minutes_consultation_extended) as minutes_consultation_extended,
            SUM(consultation_extension_count) as consultation_extension_count,
            SUM(minutes_fortunetelling) as minutes_fortunetelling,
            SUM(minutes_fortunetelling_extended) as minutes_fortunetelling_extended,
            SUM(fortunetelling_extension_count) as fortunetelling_extension_count,
            SUM(total_applicants) as total_applicants,
            SUM(total_applicants_lappi_new) as total_applicants_lappi_new,
            SUM(total_applicants_lappi_repeater) as total_applicants_lappi_repeater,
            SUM(skills_applicants) as skills_applicants,
            SUM(skills_applicants_teacher_new) as skills_applicants_teacher_new,
            SUM(skills_applicants_teacher_repeater) as skills_applicants_teacher_repeater,
            SUM(skills_sub_applicants) as skills_sub_applicants,
            SUM(skills_sub_applicants_teacher_new) as skills_sub_applicants_teacher_new,
            SUM(skills_sub_applicants_teacher_repeater) as skills_sub_applicants_teacher_repeater,
            SUM(consultation_applicants) as consultation_applicants,
            SUM(consultation_applicants_teacher_new) as consultation_applicants_teacher_new,
            SUM(consultation_applicants_teacher_repeater) as consultation_applicants_teacher_repeater,
            SUM(fortunetelling_applicants) as fortunetelling_applicants,
            SUM(fortunetelling_applicants_teacher_new) as fortunetelling_applicants_teacher_new,
            SUM(fortunetelling_applicants_teacher_repeater) as fortunetelling_applicants_teacher_repeater,
            SUM(course_sales) as course_sales,
            SUM(extension_sales) as extension_sales,
            SUM(extension_count) as extension_count,
            SUM(option_sales) as option_sales,
            SUM(option_count) as option_count,
            SUM(question_sales) as question_sales,
            SUM(question_count) as question_count,
            SUM(gift_sales) as gift_sales,
            SUM(gift_count) as gift_count,
            SUM(total_number_give_gift) as total_number_give_gift,
            SUM(total_sales_skills) as total_sales_skills,
            SUM(total_sales_skills_sub) as total_sales_skills_sub,
            SUM(total_sales_consultation) as total_sales_consultation,
            SUM(total_sales_fortunetelling) as total_sales_fortunetelling,
            SUM(total_sales) as total_sales,
            SUM(sales_commissions) as sales_commissions,
            SUM(system_commissions) as system_commissions,
            SUM(total_commissions) as total_commissions,
            SUM(other_commissions) as other_commissions,
            SUM(teacher_profit) as teacher_profit,
            SUM(sales_skills_genre_1) as sales_skills_genre_1,
            SUM(sales_skills_genre_2) as sales_skills_genre_2,
            SUM(sales_skills_genre_3) as sales_skills_genre_3,
            SUM(sales_skills_genre_4) as sales_skills_genre_4,
            SUM(sales_skills_genre_5) as sales_skills_genre_5,
            SUM(sales_skills_genre_6) as sales_skills_genre_6,
            SUM(sales_skills_genre_7) as sales_skills_genre_7,
            SUM(sales_skills_genre_8) as sales_skills_genre_8,
            SUM(sales_skills_genre_9) as sales_skills_genre_9,
            SUM(sales_skills_genre_10) as sales_skills_genre_10,
            SUM(sales_skills_genre_11) as sales_skills_genre_11,
            SUM(sales_skills_genre_12) as sales_skills_genre_12,
            SUM(sales_skills_genre_13) as sales_skills_genre_13,
            SUM(sales_consultation_genre_1) as sales_consultation_genre_1,
            SUM(sales_consultation_genre_2) as sales_consultation_genre_2,
            SUM(sales_consultation_genre_3) as sales_consultation_genre_3,
            SUM(sales_consultation_genre_4) as sales_consultation_genre_4,
            SUM(sales_consultation_genre_5) as sales_consultation_genre_5,
            SUM(sales_consultation_genre_6) as sales_consultation_genre_6,
            SUM(sales_consultation_genre_7) as sales_consultation_genre_7,
            SUM(sales_consultation_genre_8) as sales_consultation_genre_8,
            SUM(sales_consultation_genre_9) as sales_consultation_genre_9,
            SUM(sales_consultation_genre_10) as sales_consultation_genre_10,
            SUM(sales_fortunetelling_genre_1) as sales_fortunetelling_genre_1,
            SUM(sales_fortunetelling_genre_2) as sales_fortunetelling_genre_2,
            SUM(sales_fortunetelling_genre_3) as sales_fortunetelling_genre_3,
            SUM(sales_fortunetelling_genre_4) as sales_fortunetelling_genre_4,
            SUM(sales_fortunetelling_genre_5) as sales_fortunetelling_genre_5,
            SUM(sales_fortunetelling_genre_6) as sales_fortunetelling_genre_6,
            SUM(sales_fortunetelling_genre_7) as sales_fortunetelling_genre_7,
            SUM(sales_fortunetelling_genre_8) as sales_fortunetelling_genre_8,
            SUM(sales_fortunetelling_genre_9) as sales_fortunetelling_genre_9,
            SUM(sales_fortunetelling_genre_10) as sales_fortunetelling_genre_10,
            SUM(sales_fortunetelling_genre_11) as sales_fortunetelling_genre_11,
            SUM(sales_male) as sales_male,
            SUM(sales_female) as sales_female,
            SUM(sales_unapplicable) as sales_unapplicable,
            SUM(sales_not_known) as sales_not_known,
            SUM(sales_10s) as sales_10s,
            SUM(sales_20s) as sales_20s,
            SUM(sales_30s) as sales_30s,
            SUM(sales_40s) as sales_40s,
            SUM(sales_50s) as sales_50s,
            SUM(sales_60s) as sales_60s
        ';

        // Set value with category type
        $isSkills = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_1);
        $isSkillsSub = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_1);
        $isConsultation = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_2);
        $isFortunetelling = $this->setValueWithCategoryType($category, Constant::PAIR_CATEGORY_3);

        $result = $this->model
            ->selectRaw($selectSum)
            ->where([
                ['target_date', '>=', now()->parse($date['start_date'])],
                ['target_date', '<=', now()->parse($date['end_date'])->endOfDay()],
            ]);
        // if ((int)$category === DBConstant::LIST_CATEGORY_TYPE['all']) {
        //     $result = $result->where('is_skills', $isSkills)
        //         ->orWhere('is_skills_sub', $isSkillsSub)
        //         ->orWhere('is_consultation', $isConsultation)
        //         ->orWhere('is_fortunetelling', $isFortunetelling);
        // } else
        if ((int)$category === DBConstant::LIST_CATEGORY_TYPE['live_stream']) {
            $result = $result->where(function ($query) use ($isSkills, $isSkillsSub) {
                $query->where('is_skills', $isSkills)->orWhere('is_skills_sub', $isSkillsSub);
            });
        } elseif ((int)$category === DBConstant::LIST_CATEGORY_TYPE['trouble_consultation']) {
            $result = $result->where('is_consultation', $isConsultation);
        } elseif ((int)$category === DBConstant::LIST_CATEGORY_TYPE['fortune_telling']) {
            $result = $result->where('is_fortunetelling', $isFortunetelling);
        }

        return $result->first();
    }

    /**
     * Get total num of times.
     *
     * @param $request
     * @return mixed
     */
    public function getTotalNumOfSales($request)
    {
        // $month = $request->month;
        $date = [
            'start_date' => $request->start_date ?? now()->firstOfMonth(),
            'end_date' => $request->end_date ?? now()
        ];
        $arr = ['is_skills', 'is_skills_sub', 'is_consultation', 'is_fortunetelling'];
        $total = 0;

        foreach ($arr as $item) {
            $result = $this->model
                ->select($item)
                ->where([
                    ['target_date', '>=', now()->parse($date['start_date'])],
                    ['target_date', '<=', now()->parse($date['end_date'])->endOfDay()],
                    [$item, '=', 1],
                ])->count();
            $total += $result;
        }
        return $total;
    }

    /**
     * Get the target months show on Sales details.
     *
     * @param $request
     * @return mixed
     */
    public function getData($request)
    {
        // Set variable
        $type = $request->category_type ?? null;
        $categoryId = $request->category_id;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $userId = $request->userId;
        $perPage = Constant::DEFAULT_LIMIT;
        $sortColumn = $request->input('sort_column', Constant::SALE_SORT_BY_DEFAULT);
        $sortType = $request->input('sort_by', Constant::ORDER_BY_DESC);
        if (isset($request['per_page'])) {
            $perPage = $request['per_page'];
        }

        $query = $this->model->join(
            'course_schedules as cs',
            'sales.course_schedule_id',
            '=',
            'cs.course_schedule_id'
        )->join(
            'courses as co',
            'cs.course_id',
            '=',
            'co.course_id'
        )->join(
            'categories as ca',
            'co.category_id',
            '=',
            'ca.category_id'
        )->selectRaw('
            *, sales.user_id as user_id, ca.name as category_name, cs.title as course_schedule_title,
            cs.start_datetime as course_schedule_start_datetime,
            sales.course_sales+sales.extension_sales as sum_course_extension,
            co.type as co_type
        ');

        if ($type) {
            $query->where('ca.type', '=', $type);
        }

        if ($categoryId) {
            $query->where('ca.category_id', '=', $categoryId);
        }

        if ($startDate) {
            $query->where('sales.target_date', '>=', now()->parse($startDate)->startOfDay());
        }

        if ($endDate) {
            $query->where('sales.target_date', '<=', now()->parse($endDate)->endOfDay());
        }

        if ($userId) {
            $query->where('sales.user_id', '=', $userId);
        }

        return $query->where('cs.num_of_applicants', '>', DBConstant::COURSE_SCHEDULE_NOT_BOOKED)->orderBy($sortColumn, $sortType)->paginate($perPage);
    }

    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get total sales.
     *
     * @param $categoryIds
     * @return mixed|void
     */
    public function getTotalSales($categoryId)
    {
        return $this->model
            ->selectRaw('
                SUM(sales.total_sales) as total_sales,
                SUM(sales.course_sales) as course_sales,
                SUM(sales.extension_sales) as extension_sales,
                SUM(sales.option_sales) as option_sales,
                SUM(sales.question_sales) as question_sales,
                SUM(sales.gift_sales) as gift_sales,
                SUM(sales.sales_commissions) as sales_commissions,
                SUM(sales.total_applicants) as total_applicants,
                COUNT(sales.id) as num_of_courses,
                SUM(sales.total_minutes) as total_minutes,
                SUM(sales.teacher_profit_exc_tax) as teacher_profit_exc_tax,
                SUM(sales.cancellation_fee) as cancellation_fee,
                SUM(sales.system_commissions) as system_commissions,
                SUM(sales.total_applicants) as num_of_applicants,
                SUM(sales.total_minutes) as streaming_minutes,
                SUM(sales.teacher_profit_exc_tax) as teacher_profit_exc_tax,
                SUM(sales.cancellation_fee) as cancellation_fee,
                SUM(sales.other_commissions) as other_commissions,
                SUM(sales.total_commissions) as total_commissions
            ')
            ->join('course_schedules as cs', 'sales.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as c', 'cs.course_id', '=', 'c.course_id')
            ->where([
                'c.category_id' => $categoryId,
                'sales.target_date' => now()::yesterday(),
                'is_imported' => DBConstant::SALE_NOT_IMPORTED,
                'sales.cancellation_fee' => DBConstant::SALE_CANCELLATION_FEE
            ])
            ->first();
    }

    /**
     * Update sales status.
     *
     * @param int $categoryId
     * @return mixed
     */
    public function updateSales(int $categoryId)
    {
        return $this->model
            ->join('course_schedules as cs', 'sales.course_schedule_id', '=', 'cs.course_schedule_id')
            ->join('courses as c', 'cs.course_id', '=', 'c.course_id')
            ->where([
                'sales.target_date' => now()::yesterday(),
                'c.category_id' => $categoryId
            ])
            ->update(['is_imported' => DBConstant::SALE_IMPORTED]);
    }

    /**
     * Dashboard teacher.
     *
     * @param mixed $request
     * @param mixed $data
     * @return mixed
     */
    public function teacherDashboard($request, $data)
    {
        $isSkill = DBConstant::NOT_SKILL;
        $isSkillSub = DBConstant::NOT_SKILL_SUB;
        $isConsultation = DBConstant::NOT_CONSULTATION;
        $isFortunetelling = DBConstant::NOT_FORTUNETELLING;
        $userId = auth('client')->user()->user_id;
//        if ($request->category == DBConstant::TEACHER_CATEGORY_SKILLS) {
//            $isSkill = DBConstant::SKILL;
//            $isSkillSub = DBConstant::SKILL_SUB;
//        }
//
//        if ($request->category == DBConstant::TEACHER_CATEGORY_CONSULTATION) {
//            $isConsultation = DBConstant::CONSULTATION;
//        }
//
//        if ($request->category == DBConstant::TEACHER_CATEGORY_FORTUNETELLING) {
//            $isFortunetelling = DBConstant::FORTUNETELLING;
//        }
        if (auth('client')->user()->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS) {
            $isSkill = DBConstant::SKILL;
            $isSkillSub = DBConstant::SKILL_SUB;

            return $this->model
                ->selectRaw('
                SUM(is_skills) as is_skills,SUM(is_skills_sub) as is_skills_sub, SUM(is_consultation) as is_consultation,SUM(is_fortunetelling) as is_fortunetelling,
                SUM(total_minutes) as total_minutes,SUM(minutes_skills) as minutes_skills, SUM(minutes_skills_sub) as minutes_skills_sub,SUM(minutes_skills_sub_extended) as minutes_skills_sub_extended, SUM(skills_sub_extension_count) as skills_sub_extension_count,SUM(minutes_consultation) as minutes_consultation,
                SUM(minutes_consultation_extended) as minutes_consultation_extended,SUM(consultation_extension_count) as consultation_extension_count, SUM(minutes_fortunetelling) as minutes_fortunetelling,SUM(minutes_fortunetelling_extended) as minutes_fortunetelling_extended,
                SUM(fortunetelling_extension_count) as fortunetelling_extension_count,SUM(total_applicants) as total_applicants, SUM(total_applicants_lappi_new) as total_applicants_lappi_new,SUM(total_applicants_lappi_repeater) as total_applicants_lappi_repeater,
                SUM(skills_applicants) as skills_applicants,SUM(skills_applicants_teacher_new) as skills_applicants_teacher_new, SUM(skills_applicants_teacher_repeater) as skills_applicants_teacher_repeater,SUM(skills_sub_applicants) as skills_sub_applicants,
                SUM(skills_sub_applicants_teacher_new) as skills_sub_applicants_teacher_new,SUM(skills_sub_applicants_teacher_repeater) as skills_sub_applicants_teacher_repeater, SUM(consultation_applicants) as consultation_applicants,SUM(consultation_applicants_teacher_new) as consultation_applicants_teacher_new,
                SUM(consultation_applicants_teacher_repeater) as consultation_applicants_teacher_repeater,SUM(fortunetelling_applicants) as fortunetelling_applicants, SUM(fortunetelling_applicants_teacher_new) as fortunetelling_applicants_teacher_new,SUM(fortunetelling_applicants_teacher_repeater) as fortunetelling_applicants_teacher_repeater,
                SUM(course_sales) as course_sales,SUM(extension_sales) as extension_sales, SUM(extension_count) as extension_count,SUM(option_sales) as option_sales,
                SUM(option_count) as option_count,SUM(question_sales) as question_sales, SUM(question_count) as question_count,SUM(gift_sales) as gift_sales,
                SUM(gift_count) as gift_count,SUM(total_number_give_gift) as total_number_give_gift,SUM(total_sales_skills) as total_sales_skills, SUM(total_sales_skills_sub) as total_sales_skills_sub,SUM(total_sales_consultation) as total_sales_consultation,
                SUM(total_sales_fortunetelling) as total_sales_fortunetelling,SUM(total_sales) as total_sales,  SUM(sales_commissions) as sales_commissions,SUM(system_commissions) as system_commissions,
                SUM(total_commissions) as total_commissions,SUM(teacher_profit) as teacher_profit,  SUM(sales_skills_genre_1) as sales_skills_genre_1,SUM(sales_skills_genre_2) as sales_skills_genre_2,
                SUM(sales_skills_genre_3) as sales_skills_genre_3,SUM(sales_skills_genre_4) as sales_skills_genre_4,SUM(sales_skills_genre_5) as sales_skills_genre_5,SUM(sales_skills_genre_6) as sales_skills_genre_6,
                SUM(sales_skills_genre_7) as sales_skills_genre_7,SUM(sales_skills_genre_8) as sales_skills_genre_8,SUM(sales_skills_genre_9) as sales_skills_genre_9,SUM(sales_skills_genre_10) as sales_skills_genre_10,
                SUM(sales_skills_genre_11) as sales_skills_genre_11,SUM(sales_skills_genre_12) as sales_skills_genre_12,SUM(sales_skills_genre_13) as sales_skills_genre_13,SUM(sales_consultation_genre_1) as sales_consultation_genre_1,
                SUM(sales_consultation_genre_2) as sales_consultation_genre_2,SUM(sales_consultation_genre_3) as sales_consultation_genre_3,SUM(sales_consultation_genre_4) as sales_consultation_genre_4,SUM(sales_consultation_genre_5) as sales_consultation_genre_5,
                SUM(sales_consultation_genre_6) as sales_consultation_genre_6,SUM(sales_consultation_genre_7) as sales_consultation_genre_7,SUM(sales_consultation_genre_8) as sales_consultation_genre_8,SUM(sales_consultation_genre_9) as sales_consultation_genre_9,SUM(sales_consultation_genre_10) as sales_consultation_genre_10,
                SUM(sales_fortunetelling_genre_1) as sales_fortunetelling_genre_1,SUM(sales_fortunetelling_genre_2) as sales_fortunetelling_genre_2,SUM(sales_fortunetelling_genre_3) as sales_fortunetelling_genre_3,SUM(sales_fortunetelling_genre_4) as sales_fortunetelling_genre_4,
                SUM(sales_fortunetelling_genre_5) as sales_fortunetelling_genre_5,SUM(sales_fortunetelling_genre_6) as sales_fortunetelling_genre_6,SUM(sales_fortunetelling_genre_7) as sales_fortunetelling_genre_7,SUM(sales_fortunetelling_genre_8) as sales_fortunetelling_genre_8,
                SUM(sales_fortunetelling_genre_9) as sales_fortunetelling_genre_9,SUM(sales_fortunetelling_genre_10) as sales_fortunetelling_genre_10,SUM(sales_male) as sales_male,SUM(sales_not_known) as sales_not_known, SUM(sales_female) as sales_female,SUM(sales_unapplicable) as sales_unapplicable,
                SUM(sales_10s) as sales_10s,SUM(sales_20s) as sales_20s,SUM(sales_30s) as sales_30s,SUM(sales_40s) as sales_40s,SUM(sales_50s) as sales_50s,SUM(sales_60s) as sales_60s
            ')
                ->where('user_id', $userId)
                ->where('target_date', '>=', $data['startDate'])
                ->where('target_date', '<=', $data['endDate'])
                ->where(function ($query) {
                    $query->where('is_skills', DBConstant::SKILL)
                        ->orWhere('is_skills_sub', DBConstant::SKILL_SUB);
                })
                // ->where('is_skills', $isSkill)
                // ->orWhere('is_skills_sub', $isSkillSub)
                ->where('is_consultation', $isConsultation)
                ->where('is_fortunetelling', $isFortunetelling)
                ->first();
        } else if (auth('client')->user()->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION) {
            $isConsultation = DBConstant::CONSULTATION;
            $isFortunetelling = DBConstant::FORTUNETELLING;

            return $this->model
                ->selectRaw('
                SUM(is_skills) as is_skills,SUM(is_skills_sub) as is_skills_sub, SUM(is_consultation) as is_consultation,SUM(is_fortunetelling) as is_fortunetelling,
                SUM(total_minutes) as total_minutes,SUM(minutes_skills) as minutes_skills, SUM(minutes_skills_sub) as minutes_skills_sub,SUM(minutes_skills_sub_extended) as minutes_skills_sub_extended, SUM(skills_sub_extension_count) as skills_sub_extension_count,SUM(minutes_consultation) as minutes_consultation,
                SUM(minutes_consultation_extended) as minutes_consultation_extended,SUM(consultation_extension_count) as consultation_extension_count, SUM(minutes_fortunetelling) as minutes_fortunetelling,SUM(minutes_fortunetelling_extended) as minutes_fortunetelling_extended,
                SUM(fortunetelling_extension_count) as fortunetelling_extension_count,SUM(total_applicants) as total_applicants, SUM(total_applicants_lappi_new) as total_applicants_lappi_new,SUM(total_applicants_lappi_repeater) as total_applicants_lappi_repeater,
                SUM(skills_applicants) as skills_applicants,SUM(skills_applicants_teacher_new) as skills_applicants_teacher_new, SUM(skills_applicants_teacher_repeater) as skills_applicants_teacher_repeater,SUM(skills_sub_applicants) as skills_sub_applicants,
                SUM(skills_sub_applicants_teacher_new) as skills_sub_applicants_teacher_new,SUM(skills_sub_applicants_teacher_repeater) as skills_sub_applicants_teacher_repeater, SUM(consultation_applicants) as consultation_applicants,SUM(consultation_applicants_teacher_new) as consultation_applicants_teacher_new,
                SUM(consultation_applicants_teacher_repeater) as consultation_applicants_teacher_repeater,SUM(fortunetelling_applicants) as fortunetelling_applicants, SUM(fortunetelling_applicants_teacher_new) as fortunetelling_applicants_teacher_new,SUM(fortunetelling_applicants_teacher_repeater) as fortunetelling_applicants_teacher_repeater,
                SUM(course_sales) as course_sales,SUM(extension_sales) as extension_sales, SUM(extension_count) as extension_count,SUM(option_sales) as option_sales,
                SUM(option_count) as option_count,SUM(question_sales) as question_sales, SUM(question_count) as question_count,SUM(gift_sales) as gift_sales,
                SUM(gift_count) as gift_count,SUM(total_number_give_gift) as total_number_give_gift,SUM(total_sales_skills) as total_sales_skills, SUM(total_sales_skills_sub) as total_sales_skills_sub,SUM(total_sales_consultation) as total_sales_consultation,
                SUM(total_sales_fortunetelling) as total_sales_fortunetelling,SUM(total_sales) as total_sales,  SUM(sales_commissions) as sales_commissions,SUM(system_commissions) as system_commissions,
                SUM(total_commissions) as total_commissions,SUM(teacher_profit) as teacher_profit,  SUM(sales_skills_genre_1) as sales_skills_genre_1,SUM(sales_skills_genre_2) as sales_skills_genre_2,
                SUM(sales_skills_genre_3) as sales_skills_genre_3,SUM(sales_skills_genre_4) as sales_skills_genre_4,SUM(sales_skills_genre_5) as sales_skills_genre_5,SUM(sales_skills_genre_6) as sales_skills_genre_6,
                SUM(sales_skills_genre_7) as sales_skills_genre_7,SUM(sales_skills_genre_8) as sales_skills_genre_8,SUM(sales_skills_genre_9) as sales_skills_genre_9,SUM(sales_skills_genre_10) as sales_skills_genre_10,
                SUM(sales_skills_genre_11) as sales_skills_genre_11,SUM(sales_skills_genre_12) as sales_skills_genre_12,SUM(sales_skills_genre_13) as sales_skills_genre_13,SUM(sales_consultation_genre_1) as sales_consultation_genre_1,
                SUM(sales_consultation_genre_2) as sales_consultation_genre_2,SUM(sales_consultation_genre_3) as sales_consultation_genre_3,SUM(sales_consultation_genre_4) as sales_consultation_genre_4,SUM(sales_consultation_genre_5) as sales_consultation_genre_5,
                SUM(sales_consultation_genre_6) as sales_consultation_genre_6,SUM(sales_consultation_genre_7) as sales_consultation_genre_7,SUM(sales_consultation_genre_8) as sales_consultation_genre_8,SUM(sales_consultation_genre_9) as sales_consultation_genre_9,SUM(sales_consultation_genre_10) as sales_consultation_genre_10,
                SUM(sales_fortunetelling_genre_1) as sales_fortunetelling_genre_1,SUM(sales_fortunetelling_genre_2) as sales_fortunetelling_genre_2,SUM(sales_fortunetelling_genre_3) as sales_fortunetelling_genre_3,SUM(sales_fortunetelling_genre_4) as sales_fortunetelling_genre_4,
                SUM(sales_fortunetelling_genre_5) as sales_fortunetelling_genre_5,SUM(sales_fortunetelling_genre_6) as sales_fortunetelling_genre_6,SUM(sales_fortunetelling_genre_7) as sales_fortunetelling_genre_7,SUM(sales_fortunetelling_genre_8) as sales_fortunetelling_genre_8,
                SUM(sales_fortunetelling_genre_9) as sales_fortunetelling_genre_9,SUM(sales_fortunetelling_genre_10) as sales_fortunetelling_genre_10,SUM(sales_male) as sales_male,SUM(sales_not_known) as sales_not_known, SUM(sales_female) as sales_female,SUM(sales_unapplicable) as sales_unapplicable,
                SUM(sales_10s) as sales_10s,SUM(sales_20s) as sales_20s,SUM(sales_30s) as sales_30s,SUM(sales_40s) as sales_40s,SUM(sales_50s) as sales_50s,SUM(sales_60s) as sales_60s
            ')
                ->where('user_id', $userId)
                ->where('target_date', '>=', $data['startDate'])
                ->where('target_date', '<=', $data['endDate'])
                ->where('is_consultation', DBConstant::CONSULTATION)
                ->first();
        } else {
            return $this->model
                ->selectRaw('
                SUM(is_skills) as is_skills,SUM(is_skills_sub) as is_skills_sub, SUM(is_consultation) as is_consultation,SUM(is_fortunetelling) as is_fortunetelling,
                SUM(total_minutes) as total_minutes,SUM(minutes_skills) as minutes_skills, SUM(minutes_skills_sub) as minutes_skills_sub,SUM(minutes_skills_sub_extended) as minutes_skills_sub_extended, SUM(skills_sub_extension_count) as skills_sub_extension_count,SUM(minutes_consultation) as minutes_consultation,
                SUM(minutes_consultation_extended) as minutes_consultation_extended,SUM(consultation_extension_count) as consultation_extension_count, SUM(minutes_fortunetelling) as minutes_fortunetelling,SUM(minutes_fortunetelling_extended) as minutes_fortunetelling_extended,
                SUM(fortunetelling_extension_count) as fortunetelling_extension_count,SUM(total_applicants) as total_applicants, SUM(total_applicants_lappi_new) as total_applicants_lappi_new,SUM(total_applicants_lappi_repeater) as total_applicants_lappi_repeater,
                SUM(skills_applicants) as skills_applicants,SUM(skills_applicants_teacher_new) as skills_applicants_teacher_new, SUM(skills_applicants_teacher_repeater) as skills_applicants_teacher_repeater,SUM(skills_sub_applicants) as skills_sub_applicants,
                SUM(skills_sub_applicants_teacher_new) as skills_sub_applicants_teacher_new,SUM(skills_sub_applicants_teacher_repeater) as skills_sub_applicants_teacher_repeater, SUM(consultation_applicants) as consultation_applicants,SUM(consultation_applicants_teacher_new) as consultation_applicants_teacher_new,
                SUM(consultation_applicants_teacher_repeater) as consultation_applicants_teacher_repeater,SUM(fortunetelling_applicants) as fortunetelling_applicants, SUM(fortunetelling_applicants_teacher_new) as fortunetelling_applicants_teacher_new,SUM(fortunetelling_applicants_teacher_repeater) as fortunetelling_applicants_teacher_repeater,
                SUM(course_sales) as course_sales,SUM(extension_sales) as extension_sales, SUM(extension_count) as extension_count,SUM(option_sales) as option_sales,
                SUM(option_count) as option_count,SUM(question_sales) as question_sales, SUM(question_count) as question_count,SUM(gift_sales) as gift_sales,
                SUM(gift_count) as gift_count,SUM(total_number_give_gift) as total_number_give_gift,SUM(total_sales_skills) as total_sales_skills, SUM(total_sales_skills_sub) as total_sales_skills_sub,SUM(total_sales_consultation) as total_sales_consultation,
                SUM(total_sales_fortunetelling) as total_sales_fortunetelling,SUM(total_sales) as total_sales,  SUM(sales_commissions) as sales_commissions,SUM(system_commissions) as system_commissions,
                SUM(total_commissions) as total_commissions,SUM(teacher_profit) as teacher_profit,  SUM(sales_skills_genre_1) as sales_skills_genre_1,SUM(sales_skills_genre_2) as sales_skills_genre_2,
                SUM(sales_skills_genre_3) as sales_skills_genre_3,SUM(sales_skills_genre_4) as sales_skills_genre_4,SUM(sales_skills_genre_5) as sales_skills_genre_5,SUM(sales_skills_genre_6) as sales_skills_genre_6,
                SUM(sales_skills_genre_7) as sales_skills_genre_7,SUM(sales_skills_genre_8) as sales_skills_genre_8,SUM(sales_skills_genre_9) as sales_skills_genre_9,SUM(sales_skills_genre_10) as sales_skills_genre_10,
                SUM(sales_skills_genre_11) as sales_skills_genre_11,SUM(sales_skills_genre_12) as sales_skills_genre_12,SUM(sales_skills_genre_13) as sales_skills_genre_13,SUM(sales_consultation_genre_1) as sales_consultation_genre_1,
                SUM(sales_consultation_genre_2) as sales_consultation_genre_2,SUM(sales_consultation_genre_3) as sales_consultation_genre_3,SUM(sales_consultation_genre_4) as sales_consultation_genre_4,SUM(sales_consultation_genre_5) as sales_consultation_genre_5,
                SUM(sales_consultation_genre_6) as sales_consultation_genre_6,SUM(sales_consultation_genre_7) as sales_consultation_genre_7,SUM(sales_consultation_genre_8) as sales_consultation_genre_8,SUM(sales_consultation_genre_9) as sales_consultation_genre_9,SUM(sales_consultation_genre_10) as sales_consultation_genre_10,
                SUM(sales_fortunetelling_genre_1) as sales_fortunetelling_genre_1,SUM(sales_fortunetelling_genre_2) as sales_fortunetelling_genre_2,SUM(sales_fortunetelling_genre_3) as sales_fortunetelling_genre_3,SUM(sales_fortunetelling_genre_4) as sales_fortunetelling_genre_4,
                SUM(sales_fortunetelling_genre_5) as sales_fortunetelling_genre_5,SUM(sales_fortunetelling_genre_6) as sales_fortunetelling_genre_6,SUM(sales_fortunetelling_genre_7) as sales_fortunetelling_genre_7,SUM(sales_fortunetelling_genre_8) as sales_fortunetelling_genre_8,
                SUM(sales_fortunetelling_genre_9) as sales_fortunetelling_genre_9,SUM(sales_fortunetelling_genre_10) as sales_fortunetelling_genre_10,SUM(sales_male) as sales_male,SUM(sales_not_known) as sales_not_known, SUM(sales_female) as sales_female,SUM(sales_unapplicable) as sales_unapplicable,
                SUM(sales_10s) as sales_10s,SUM(sales_20s) as sales_20s,SUM(sales_30s) as sales_30s,SUM(sales_40s) as sales_40s,SUM(sales_50s) as sales_50s,SUM(sales_60s) as sales_60s
            ')
                ->where('user_id', $userId)
                ->where('target_date', '>=', $data['startDate'])
                ->where('target_date', '<=', $data['endDate'])
                ->where('is_fortunetelling', DBConstant::FORTUNETELLING)
                ->first();
        }

    }

    /**
     * Get Sale Target Month.
     *
     * @param $data
     * @return mixed|void
     */
    public function getSaleTargetMonth($data)
    {
        return $this->model
            ->join('course_schedules as cs', 'sales.course_schedule_id', '=', 'cs.course_schedule_id')
            ->where([
                ['sales.target_date', '>=', $data['start_date']],
                ['sales.target_date', '<=', $data['end_date']],
                'sales.user_id' => $data['user_id'],
            ])
            ->orderBy('sales.id', Constant::ORDER_BY_ASC)
            ->get();
    }

    /**
     * Count Sale Amount.
     *
     * @return mixed|void
     */
    public function countSaleAmount()
    {
        return $this->model
            ->selectRaw('DISTINCT(sales.user_id),COUNT(sales.user_id) as course_schedule_count, avg(avg_rating) as avg')
            ->join(DB::raw('(SELECT course_schedule_id, avg(rating) as avg_rating from reviews group by course_schedule_id) rv'), function ($join) {
                $join->on('rv.course_schedule_id', '=', 'sales.course_schedule_id');
            })
            ->join('users as u', 'sales.user_id', '=', 'u.user_id')
            ->groupBy('sales.user_id');
    }

    /**
     * Count Sale Amount By Target Date.
     *
     * @param $periodDaysStandard
     * @return mixed|void
     */
    public function countSaleAmountByTargetDate($periodMonthStandard)
    {
        return $this->model
            ->selectRaw('DISTINCT(sales.user_id),COUNT(sales.user_id) as course_schedule_count, avg(avg_rating) as avg')
            ->join(DB::raw('(SELECT course_schedule_id, avg(rating) as avg_rating from reviews group by course_schedule_id) rv'), function ($join) {
                $join->on('rv.course_schedule_id', '=', 'sales.course_schedule_id');
            })
            ->join('users as u', 'sales.user_id', '=', 'u.user_id')
            ->groupBy('sales.user_id')
            ->where('sales.target_date', '<=', now()->subMonth($periodMonthStandard));
    }

    public function saleProfitLiveStream($request)
    {
        // $currentYear = $request->year ?? now()->year;
        if (isset($request->month)) {
            $date = $request->year . '/' . $request->month . '/01';
            $data = [
                'startDate' => Carbon::parse($date)->startOfMonth()->toDateString(),
                'endDate' => Carbon::parse($date)->endOfMonth()->toDateString(),
                'year' => $request->year,
                'month' => $request->month,
            ];
        } else {
            $data = [
                'startDate' => Carbon::now()->startOfMonth()->toDateString(),
                'endDate' => Carbon::now()->endOfMonth()->toDateString(),
                'year' => Carbon::now()->year,
                'month' => Carbon::now()->month,
            ];
        }
        return $this->getSaleProfitLiveStream($data);
    }

    public function getSaleProfitLiveStream($data)
    {
        $profitLiveStream = $this->model
            ->select('sales.*', 'users.teacher_category_skills', 'course_schedules.status as course_schedules_status')
            ->join('users', 'users.user_id', 'sales.user_id')
            ->join('course_schedules', 'sales.course_schedule_id', 'course_schedules.course_schedule_id')
            ->join('course_schedules as cs', 'cs.course_schedule_id', 'sales.course_schedule_id')
            ->where('sales.user_id', auth('client')->id())
            ->whereBetween('sales.target_date', [$data['startDate'], $data['endDate']])
            ->orderBy('sales.target_date', 'ASC')
            ->groupBy('sales.id')
            ->get();
        return [
            'data' => $data,
            'profitLiveStream' => $profitLiveStream
        ];
    }

    public function getTransferApplyLiveStream($request)
    {
        if (now()->day >= 1 && now()->day <= 15) {
            $isWithdrawMoney = resolve(CashRepository::class)->transferRecordLastMonth(
                now()->setDate(now()->year, now()->month, 1)->startOfDay(),
                now()->setDate(now()->year, now()->month, 15)->endOfDay()
            );
        } else {
            $isWithdrawMoney = resolve(CashRepository::class)->transferRecordLastMonth(
                now()->setDate(now()->year, now()->month, 16)->startOfDay(),
                now()->endOfMonth()->endOfDay()
            );
        }

        $isPayout = false;
        $transferApply = [];
        $firstDate = null;
        for ($i = 0; $i < Constant::MONTH_TRANSFER_APPLY; $i++) {
            $now = isset($request->month) ? now()->setDate($request->year, $request->month - $i, 1) :
                now()->setDate(now()->year, now()->month - $i, 1);
            $firstDate = $firstDate ?? (clone $now);
            $dataTransfersInMonth = resolve(CashRepository::class)->dataTransfer($now);

            $numberOfTransfers = $dataTransfersInMonth['count'];
            $totalTransfer = $dataTransfersInMonth['sum'];
            if (!$isPayout) {
                $dataCashEndOfMonth = resolve(CashRepository::class)->getDataCashEndOfMonth($now);
                $profit = $dataCashEndOfMonth['teacher_profit'];
                $balance = $dataCashEndOfMonth['balance'];
                $saleTaxsInMonth = $dataCashEndOfMonth['sale_tax'];
                if (!$numberOfTransfers && $balance) {
                    $dataCashLastMonth = resolve(CashRepository::class)->getDataCashBeforeEndOfMonth((clone $now)->subMonth());
                    $profit -= $dataCashLastMonth['teacher_profit'];
                    $balance -= $dataCashLastMonth['balance'];
                    $saleTaxsInMonth -= $dataCashLastMonth['sale_tax'];
                }
            } else {
                $balance = $profit = 0;
            }

            if ($numberOfTransfers) {
                $isPayout = true;
            }
            if ($i === 2) {

            }
            if (!$i) {
                if (!$numberOfTransfers) {
                    $monthColor = $payoutColor = $balanceColor = '';
                } else {
                    $monthColor = '';
                    $payoutColor = $balanceColor = 'color-red';
//                    if ($profit) {
//                        $balanceColor = '';
//                    }
                    if ($profit || $now->format('m') === now()->format('m')) {
                        $balanceColor = '';
                    }
                }
            } else {
                $monthColor = 'color-red';
                $payoutColor = 'color-red';
                $balanceColor = 'color-red';
                if ($profit) {
                    $balanceColor = '';
                }
            }

            $transferApply[$i]['month'] = $now;
//            $transferApply[$i]['sellerProfits'] = $sellerProfitInMonth;
            $transferApply[$i]['saleTaxs'] = $saleTaxsInMonth;
            $transferApply[$i]['profit'] = $profit;
            $transferApply[$i]['balance'] = $balance;
            $transferApply[$i]['numberOfTransfers'] = $numberOfTransfers;
            $transferApply[$i]['totalTransfer'] = $totalTransfer;
            $transferApply[$i]['monthColor'] = $monthColor;
            $transferApply[$i]['payoutColor'] = $payoutColor;
            $transferApply[$i]['balanceColor'] = $balanceColor;
        }

        return [
            'isWithdrawMoney' => $isWithdrawMoney,
            'transferApply' => $transferApply,
            'month' => $firstDate->month,
            'year' => $firstDate->year
        ];
    }
}
