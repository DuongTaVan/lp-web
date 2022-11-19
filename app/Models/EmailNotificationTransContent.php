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
class EmailNotificationTransContent extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "email_notification_trans_contents";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'email_notification_trans_content_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'to_user_ids',
        'scheduled_at',
        'is_delivered',
        'delivered_at'
    ];

}
