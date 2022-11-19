<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class QuestionTicket.
 *
 * @package namespace App\Models;
 */
class QuestionTicket extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "question_tickets";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'question_ticket_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'course_schedule_id', 'points_equivalent', 'status'];

}
