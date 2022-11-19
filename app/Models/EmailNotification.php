<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EmailNotification.
 *
 * @package namespace App\Models;
 */
class EmailNotification extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "email_notifications";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to_email',
        'title',
        'body',
        'scheduled_at',
        'status',
        'sent_at'
    ];

}
