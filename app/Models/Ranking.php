<?php

namespace App\Models;

use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Ranking.
 *
 * @package namespace App\Models;
 */
class Ranking extends Model implements Transformable
{
    use ManageFile;
    use TransformableTrait;

    protected $table = "rankings";

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
    protected $fillable = ['category', 'target_date', 'course_id', 'num_of_applicants'];

    protected $appends = [
        'month_day', 'hour_minute', 'two_days_before', 'full_name', 'thumbnail', 'rating_custom', 'profile_thumbnail'
    ];

    /**
     * Get profile thumbnail image.
     *
     * @param $value
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
        if (!$this->file_name) {
            return asset('assets/img/portal/default-image.svg');
        }

        return $this->getS3FileUrl($this->dir_path . '/' . $this->file_name);
        if (!$this->file_name) return asset('assets/img/portal/default-image.svg');
        $nameExt = explode(".", $this->file_name);
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl( $this->dir_path . '/' . $nameExt[0] . '.' . $nameExt[1]) ?? asset('assets/img/portal/default-image.svg');
            //return $this->getS3FileUrl('thumbnails/' . $this->dir_path . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/portal/default-image.svg');
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
            return now()->parse($this->startTime)->format('Y/m/d');
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
        $timeStart = now()->parse(isset($this->actual_start_date) ? $this->actual_start_date : $this->start_datetime)->format('H:i');
        $timeEnd = now()->parse(isset($this->actual_end_date) ? $this->actual_end_date : $this->end_datetime)->format('H:i');
        return $timeStart . ' - ' . $timeEnd;
    }


    /**
     * Get the two days before with signed.
     *
     * @return string
     */
    public function getTwoDaysBeforeAttribute()
    {
        $monthNow = Carbon::now()->month;
        $dayNow = Carbon::now()->day;
        $monthFirst = Carbon::now()->subDays(2)->month;
        $dayFirst = Carbon::now()->subDays(2)->day;
        return $monthFirst . '/' . $dayFirst . '~' . $monthNow . '/' . $dayNow;
    }

    /**
     * Get courses from courses table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
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

}
