<?php

namespace App\Models;

use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PageView.
 *
 * @package namespace App\Models;
 */
class PageView extends Model implements Transformable
{
    use TransformableTrait, ManageFile;

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
    protected $fillable = [
        'user_id',
        'view_count',
        'is_top_page',
        'is_skills',
        'is_consultation',
        'is_fortunetelling',
        'to_user_id',
        'to_course_schedule_id',
        'viewed_at',
    ];

    /**
     * Get profile thumbnail image.
     *
     * @return string|void
     */
    public function getProfileThumbnailAttribute()
    {
        if (!$this->profile_image) return asset('assets/img/clients/header-common/not-login.svg');
        $nameExt = explode(".", $this->getOriginal('profile_image'));
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl('thumbnails' . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/clients/header-common/not-login.svg');
        }
    }

    /**
     * Get full name user.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ($this->user_type == DBConstant::USER_TEACHER && $this->name_use == DBConstant::USER_REALNAME) {
            return "{$this->last_name_kanji} {$this->first_name_kanji}";
        }

        return $this->nickname;
    }

    /**
     * Get the rating with signed.
     *
     * @return float|int
     */
    public function getRatingCustomAttribute()
    {
        return ratingProcess($this->rating);
    }

    /**
     * Get thumbnail image.
     *
     * @return string|void
     */
    public function getThumbnailAttribute()
    {
        if (!$this->file_name) return asset('assets/img/portal/default-image.svg');
        $nameExt = explode(".", $this->file_name);
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl('thumbnails/' . $this->dir_path . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/portal/default-image.svg');
        }
    }

    /**
     * Get the month and day with signed.
     *
     * @return string
     */
    public function getMonthDayAttribute()
    {
        if (Route::currentRouteName() == 'client.teacher.my-page.service-list') {
            return now()->parse($this->start_datetime)->format('Y/m/d');
        }

        $month = now()->parse($this->start_datetime)->format('m');
        $day = now()->parse($this->start_datetime)->format('d');

        return $month . Lang::get('labels.calendar.month') . $day . Lang::get('labels.calendar.day');
    }

    /**
     * Get the hour and minute with signed.
     *
     * @return string
     */
    public function getHourMinuteAttribute()
    {
        $timeStart = now()->parse($this->start_datetime)->format('H:i');
        $timeEnd = now()->parse($this->end_datetime)->format('H:i');
        return $timeStart . ' - ' . $timeEnd;
    }
}
