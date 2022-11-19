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
class OptionalExtra extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "optional_extras";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'optional_extra_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_id', 'title', 'price'];

}
