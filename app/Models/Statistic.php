<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Statistic.
 *
 * @package namespace App\Models;
 */
class Statistic extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "statistics";

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
        'category_id', 'target_date', '365_days_ago', 'total_sales', 'total_sales_ly', 'course_sales', 'course_sales_ly',
        'extension_sales', 'extension_sales_ly', 'option_sales', 'option_sales_ly', 'question_sales', 'question_sales_ly',
        'gift_sales', 'gift_sales_ly', 'sales_commissions', 'sales_commissions_ly', 'system_commissions', 'system_commissions_ly',
        'num_of_applicants', 'num_of_applicants_ly', 'num_of_courses', 'num_of_courses_ly', 'streaming_minutes', 'streaming_minutes_ly',
        'teacher_profit_exc_tax', 'teacher_profit_exc_tax_ly', 'cancellation_fee', 'cancellation_fee_ly', 'other_commissions',
        'other_commissions_ly', 'total_commissions', 'total_commissions_ly'
    ];

}
