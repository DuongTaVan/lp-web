<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OptionalExtraMapping.
 *
 * @package namespace App\Models;
 */
class OptionalExtraMapping extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "optional_extra_mappings";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_schedule_id', 'optional_extra_id'];

}
