<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BoxNotification.
 *
 * @package namespace App\Models;
 */
class BoxNotification extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "box_notifications";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'box_notification_master_content_id',
        'box_notification_trans_content_id',
        'is_read',
        'read_at'
    ];

    /**
     * Get the boxNotificationTrans that owns the box notification.
     */
    public function boxNotificationTrans()
    {
        return $this->belongsTo(BoxNotificationTransContent::class, 'box_notification_trans_content_id');
    }

    /**
     * Get the month and day with signed.
     *
     * @return string
     */
    public function getMonthDayAttribute()
    {
        $month = now()->parse($this->created_at)->month;
        $day = now()->parse($this->created_at)->day;
        return $month . Lang::get('labels.calendar.month') . $day . Lang::get('labels.calendar.day');
    }

    /**
     * Get the hour and minute with signed.
     *
     * @return string
     */
    public function getHourMinuteAttribute()
    {
        $timeStart = now()->parse($this->created_at)->format('H:i');
        $timeEnd = now()->parse($this->created_at)->format('H:i');
        return $timeStart . ' - ' . $timeEnd;
    }
}
