<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Applicant.
 *
 * @package namespace App\Models;
 */
class Applicant extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'applicant_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'course_schedule_id',
        'is_lappi_new',
        'is_lappi_repeater',
        'is_teacher_new',
        'is_teacher_repeater',
        'lappi_repeat_count',
        'teacher_repeat_count',
        'canceled_at',
        'is_reviewed',
    ];

}
