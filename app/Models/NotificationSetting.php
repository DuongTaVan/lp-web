<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class NotificationSetting.
 *
 * @package namespace App\Models;
 */
class NotificationSetting extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "notification_settings";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'message', 'followed_or_faved', 'special_offers', 'maintenance'];

}
