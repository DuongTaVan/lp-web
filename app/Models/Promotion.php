<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PromotionalMessage.
 */
class Promotion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promotions';

    protected $dates = ['started_at', 'finished_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'course_id', 'started_at', 'finished_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
