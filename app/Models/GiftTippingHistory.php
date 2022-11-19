<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GiftTippingHistory.
 *
 * @package namespace App\Models;
 */
class GiftTippingHistory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "gift_tipping_histories";

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
    protected $fillable = ['from_user_id', 'to_user_id', 'course_schedule_id', 'points_equivalent', 'tipped_at'];

}
