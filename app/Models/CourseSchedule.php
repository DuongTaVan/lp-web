<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Lang;

/**
 * Class CourseSchedule.
 *
 * @package namespace App\Models;
 */
class CourseSchedule extends Model implements Transformable
{
    use TransformableTrait;
    use ManageFile;

    protected $dates = ['start_datetime', 'actual_start_date', 'actual_end_date', 'end_datetime', 'canceled_at'];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_schedule_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'type',
        'parent_course_schedule_id',
        'status',
        'title',
        'subtitle',
        'body',
        'flow',
        'cautions',
        'minutes_required',
        'price',
        'fixed_num',
        'num_of_applicants',
        'purchase_deadline',
        'start_datetime',
        'end_datetime',
        'agora_channel',
        'agora_token',
        'canceled_at',
        'group',
        'actual_start_date',
        'actual_end_date',
        'is_mask_required',
        'created_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'month_day', 'hour_minute', 'image', 'current_age', 'full_name', 'thumbnail', 'rating_custom', 'profile_thumbnail'
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
        if (!$this->file_name) return asset('assets/img/portal/default-image.svg');
        $nameExt = explode(".", $this->file_name);
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl('thumbnails/' . $this->dir_path . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/portal/default-image.svg');
        }
    }

    /**
     * Get age user.
     *
     * @return string
     */

    public function getCurrentAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
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
        $timeStart = now()->parse(isset($this->actual_start_date) ? $this->actual_start_date : $this->start_datetime)->format('H:i');
        $timeEnd = now()->parse(isset($this->actual_end_date) ? $this->actual_end_date : $this->end_datetime)->format('H:i');
        return $timeStart . ' - ' . $timeEnd;
    }

    public function getImageAttribute()
    {
        return $this->getS3FileUrl($this->dir_path . '/' . $this->file_name) ?? asset('assets/img/portal/default-image.svg');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function optionalExtras()
    {
        return $this->belongsToMany(OptionalExtra::class, 'optional_extra_mappings', 'course_schedule_id', 'optional_extra_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseChildren()
    {
        return $this->hasMany(CourseSchedule::class, 'parent_course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countPurchase()
    {
        return $this->hasMany(Purchase::class, 'course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchasesDetail()
    {
        return $this->hasOne(PurchaseDetail::class, 'course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questionTickets()
    {
        return $this->hasMany(QuestionTicket::class, 'course_schedule_id');
    }

    /**
     * @return string
     */
    public function getStartTimeAttribute()
    {
        $hourStart = now()->parse($this->start_datetime)->hour;
        $minuteStart = now()->parse($this->start_datetime)->minute;

        return now()->parse($hourStart . ':' . $minuteStart)->format('H:i');
    }

    /**
     * Datetime to sub-course_detail
     *
     * @return string
     */
    protected function getDatetimeDetailAttribute()
    {
        return now()->parse($this->start_datetime)->format('Y/m/d') .
            ' ' . now()->parse($this->start_datetime)->format('H') .
            '時' . now()->parse($this->start_datetime)->format('i') .
            '分-' . now()->parse($this->end_datetime)->format('H') .
            '時' . now()->parse($this->end_datetime)->format('i') .
            '分';
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

//    /**
//     * Get start datetime with locale string
//     *
//     * @return string
//     */
//    public function getStartDatetimeStringAttribute()
//    {
//        return $this->start_datetime->toString();
//    }
//
//    /**
//     * Get end datetime with locale string
//     *
//     * @return string
//     */
//    public function getEndDatetimeStringAttribute()
//    {
//        return $this->end_datetime->toString();
//    }

    /**
     * @return mixed
     */
    public function imagePaths()
    {
        return $this->hasMany(ImagePath::class, 'course_schedule_id', 'course_schedule_id');
    }

    /**
     * Get the full image url with signed.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->getS3FileUrl($this->dir_path . '/' . $this->file_name) ?? asset('assets/img/portal/default-image.svg');
    }
}
