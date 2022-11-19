<?php

namespace App\Models;

use App\Enums\Constant;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Sale.
 *
 * @package namespace App\Models;
 */
class Sale extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'course_schedule_id', 'target_date', 'cash_id', 'is_skills', 'is_skills_sub', 'is_consultation',
        'is_fortunetelling', 'total_minutes', 'minutes_skills', 'minutes_skills_sub', 'minutes_skills_sub_extended',
        'skills_sub_extension_count', 'minutes_consultation', 'minutes_consultation_extended', 'consultation_extension_count',
        'minutes_fortunetelling', 'minutes_fortunetelling_extended', 'fortunetelling_extension_count',
        'total_applicants', 'total_applicants_lappi_new', 'total_applicants_lappi_repeater', 'skills_applicants',
        'skills_applicants_teacher_new', 'skills_applicants_teacher_repeater', 'skills_sub_applicants',
        'skills_sub_applicants_teacher_new', 'skills_sub_applicants_teacher_repeater', 'consultation_applicants',
        'consultation_applicants_teacher_new', 'consultation_applicants_teacher_repeater', 'fortunetelling_applicants',
        'fortunetelling_applicants_teacher_new', 'fortunetelling_applicants_teacher_repeater', 'base_price', 'course_sales',
        'extension_sales', 'extension_count', 'option_sales', 'option_count', 'question_sales', 'question_count', 'gift_sales',
        'gift_count', 'total_number_give_gift', 'total_sales_skills', 'total_sales_skills_sub', 'total_sales_consultation', 'total_sales_fortunetelling',
        'total_sales', 'sales_commissions', 'system_commissions', 'total_commissions', 'teacher_profit', 'tax_rate', 'tax_amount',
        'teacher_profit_exc_tax', 'sales_skills_genre_1', 'sales_skills_genre_2', 'sales_skills_genre_3', 'sales_skills_genre_4',
        'sales_skills_genre_5', 'sales_skills_genre_6', 'sales_skills_genre_7', 'sales_skills_genre_8', 'sales_skills_genre_9',
        'sales_skills_genre_10', 'sales_skills_genre_11', 'sales_skills_genre_12', 'sales_skills_genre_13', 'sales_consultation_genre_1',
        'sales_consultation_genre_2', 'sales_consultation_genre_3', 'sales_consultation_genre_4', 'sales_consultation_genre_5',
        'sales_consultation_genre_6', 'sales_consultation_genre_7', 'sales_consultation_genre_8', 'sales_consultation_genre_9', 'sales_consultation_genre_10',
        'sales_fortunetelling_genre_1', 'sales_fortunetelling_genre_2', 'sales_fortunetelling_genre_3',
        'sales_fortunetelling_genre_4', 'sales_fortunetelling_genre_5', 'sales_fortunetelling_genre_6',
        'sales_fortunetelling_genre_7', 'sales_fortunetelling_genre_8', 'sales_fortunetelling_genre_9',
        'sales_fortunetelling_genre_10', 'sales_fortunetelling_genre_11', 'sales_male', 'sales_female', 'sales_not_known',
        'sales_unapplicable', 'sales_10s', 'sales_20s', 'sales_30s', 'sales_40s', 'sales_50s', 'sales_60s', 'is_imported',
        'cancellation_fee', 'other_commissions','cash_balance', 'payout_id', 'payout_status'
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'seller_profit', 'sale_tax'
    ];

    /**
     * Get the rating with signed.
     *
     * @return string
     */
    public function getSellerProfitAttribute()
    {
        if ($this->teacher_category_skills == Constant::TEACHER_CATEGORY_SKILL) {
            return $this->total_sales - $this->sales_commissions - $this->system_commissions - $this->teacher_profit;
        }

        return $this->total_sales - $this->sales_commissions - $this->teacher_profit;
    }

    /**
     * Get the rating with signed.
     *
     * @return string
     */
    public function getSaleTaxAttribute()
    {
        if ($this->teacher_category_skills == Constant::TEACHER_CATEGORY_SKILL) {
            return $this->sales_commissions + $this->system_commissions;
        }

        return $this->sales_commissions;
    }

}
