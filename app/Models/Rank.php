<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Rank.
 *
 * @package namespace App\Models;
 */
class Rank extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "ranks";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'rank_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['rank_id', 'rank_level', 'badge_name', 'num_of_courses_held_standard','avg_rating_standard','period_days_standard'];

}
