<?php

namespace App\Models;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Course.
 *
 * @package namespace App\Models;
 */
class Course extends Model implements Transformable
{
    use TransformableTrait, ManageFile;

    protected $table = "courses";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'parent_course_id', 'category_id', 'status', 'title', 'subtitle', 'group',
        'body', 'flow', 'cautions', 'minutes_required', 'price', 'fixed_num', 'updated_at', 'count_public',
        'dist_method', 'rating', 'num_of_ratings', 'approval_status', 'is_archived', 'is_mask_required', 'num_of_sales', 'last_public_datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'rating_custom', 'image_url', 'thumbnail', 'month_day', 'hour_minute', 'full_name', 'profile_thumbnail'
    ];

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

    /**
     * Get the user that owns the course.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * Get the identity verification status text.
     *
     * @return string
     */
    public function getIdentityVerificationStatusTextAttribute()
    {
        if (array_key_exists($this->identity_verification_status, Constant::INDENTITY_VERIFICATION_STATUS_TEXT)) {
            return Constant::INDENTITY_VERIFICATION_STATUS_TEXT[$this->identity_verification_status];
        }

        return null;
    }

    /**
     * Get the business card verification status text.
     *
     * @return string
     */
    public function getBusinessCardVerificationStatusTextAttribute()
    {
        if (array_key_exists($this->business_card_verification_status, Constant::BUSINESS_CARD_VERIFICATION_STATUS_TEXT)) {
            return Constant::BUSINESS_CARD_VERIFICATION_STATUS_TEXT[$this->business_card_verification_status];
        }

        return null;
    }

    /**
     * Get the nda status text.
     *
     * @return string
     */
    public function getNdaStatusTextAttribute()
    {
        if (array_key_exists($this->nda_status, Constant::NDA_STATUS_TEXT)) {
            return Constant::NDA_STATUS_TEXT[$this->nda_status];
        }

        return null;
    }

    /**
     * @return mixed
     */
    public function imagePaths()
    {
        return $this->hasMany(ImagePath::class, 'course_id');
    }

    public function imagePathByDisplayOrder()
    {

        return $this->hasOne(ImagePath::class, 'course_id')
            ->where('display_order', Constant::IMAGE_DISPLAY_ORDER)->where('type', Constant::IMAGE_TYPE)->where('status', Constant::IMAGE_STATUS)
            ->withDefault();
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
//        $nameExt = explode(".", $this->file_name);
//        if (isset($nameExt[0])) {
//            return $this->getS3FileUrl($this->dir_path . '/' . $nameExt[0] . '.' . $nameExt[1]) ?? asset('assets/img/portal/default-image.svg');
//            return $this->getS3FileUrl('thumbnails/' . $this->dir_path . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/portal/default-image.svg');
//        }
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imageCourse()
    {
        return $this->hasOne(ImagePath::class, 'course_id')
            ->where('display_order', DBConstant::IMAGE_COURSE_DISPLAY)
            ->where('type', DBConstant::IMAGE_TYPE_COURSE);
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
     * Datetime to sub-course_detail
     *
     * @return string
     */
    protected function getDatetimeDetailAttribute()
    {
        $sh = now()->parse($this->start_datetime)->hour;
        $sm = now()->parse($this->start_datetime)->minute;
        $eh = now()->parse($this->end_datetime)->hour;
        $em = now()->parse($this->end_datetime)->minute;

        return now()->parse($this->start_datetime)->format('Y/m/d') . ' ' .
            ($sh < 10 ? '0' . $sh : $sh) . '時' . ($sm < 10 ? '0' . $sm : $sm) . '分~' .
            ($eh < 10 ? '0' . $eh : $eh) . '時' . ($em < 10 ? '0' . $em : $em) . '分';
    }

    public function courseSchedules()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->orderBy('start_datetime');
    }

    public function courseSchedulesSub()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->whereIn('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_CLONE, DBConstant::COURSE_SCHEDULES_STATUS_PREVIEW])
            ->orderBy('course_schedules.start_datetime');
    }

    public function courseSchedulesCheckPurchase()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->select(
                'course_schedules.*',
                'purchases.purchase_id'
            )
            ->leftJoin('purchases', function ($q) {
                $q->on('purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', auth('client')->id());
            })
            ->orderBy('course_schedules.start_datetime');
    }

    public function courseSchedulesMain()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->where('course_schedules.type', DBConstant::COURSE_SCHEDULES_TYPE_RESERVATION);
    }

    public function courseSchedulesOpen()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN);
    }

    /**
     * Get course schedules.
     *
     * where status in open and draft [0, 9].
     * @return HasMany
     */
    public function courseSchedulesOpenAndDraft()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->whereIn('course_schedules.status', [DBConstant::STATUS_COURSE_SCHEDULE_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT]);
    }

    public function courseSchedulesOpenAndPurchase()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
            ->where('course_schedules.purchase_deadline', '>', now());
    }

    public function courseSchedulesCanPurchase()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->select(
                'course_schedules.course_schedule_id',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.actual_start_date',
                'course_schedules.actual_end_date',
                'course_schedules.purchase_deadline',
                'purchases.purchase_id'
            )
            ->leftJoin('purchases', function ($q) {
                $q->on('purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', auth('client')->id());
            })
            ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
            ->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
            ->where('course_schedules.purchase_deadline', '>', now());
    }

    public function courseSchedulesCanPurchaseOrder()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->select(
                'course_schedules.course_schedule_id',
                'course_schedules.start_datetime',
                'course_schedules.end_datetime',
                'course_schedules.actual_start_date',
                'course_schedules.actual_end_date',
                'course_schedules.purchase_deadline',
                'purchases.purchase_id'
            )
            ->leftJoin('purchases', function ($q) {
                $q->on('purchases.course_schedule_id', '=', 'course_schedules.course_schedule_id')
                    ->where('purchases.user_id', auth('client')->id());
            })
            ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
            ->where('course_schedules.status', DBConstant::STATUS_COURSE_SCHEDULE_OPEN)
            ->where('course_schedules.purchase_deadline', '>', now())
            ->orderBy('course_schedules.start_datetime');
    }

    public function courseSchedulesNotClose()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->whereRaw('course_schedules.num_of_applicants < course_schedules.fixed_num')
            ->whereIn('course_schedules.status', [DBConstant::COURSE_SCHEDULES_STATUS_OPEN, DBConstant::COURSE_SCHEDULES_STATUS_DRAFT]);
    }

    public function courseSchedulesOpenAndClose()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id')
            ->whereIn('course_schedules.status', [
                DBConstant::COURSE_SCHEDULES_STATUS_OPEN,
                DBConstant::COURSE_SCHEDULES_STATUS_CLOSED,
                DBConstant::COURSE_SCHEDULES_STATUS_RECORDED
            ])->orderBy('course_schedules.start_datetime');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function purchases()
    {
        return $this->hasManyThrough(Purchase::class, CourseSchedule::class, 'course_id', 'course_schedule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function applicant()
    {
        return $this->hasManyThrough(Applicant::class, CourseSchedule::class, 'course_id', 'course_schedule_id')->whereNull('applicants.canceled_at');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function reviews()
    {
        return $this->hasManyThrough(Review::class, CourseSchedule::class, 'course_id', 'course_schedule_id');
    }

    /**
     * @return HasMany
     */
    public function courseChildren()
    {
        return $this->hasMany(Course::class, 'parent_course_id');
    }

    /**
     * @return HasMany
     */
    public function courseScheduleChildren()
    {
        return $this->hasMany(CourseSchedule::class, 'course_id', 'parent_course_id');
    }

    /**
     * Get category from courses table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function optionalExtras()
    {
        return $this->hasMany(OptionalExtra::class, 'course_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'parent_course_id')->where('user_id', auth('client')->id());
    }

    public function courseMain()
    {
        return $this->hasMany(Course::class, 'parent_course_id')->where('user_id', auth('client')->id())->whereNull('category_id');
    }

    public function coursesParent()
    {
        return $this->hasMany(Course::class, 'parent_course_id')->where('user_id', auth('client')->id())->where('type', '<>', Constant::TYPE_COURSE_PARENT);
    }

    public function subCourses()
    {
        return $this->hasOne(__CLASS__, 'parent_course_id')
            ->where('type', DBConstant::COURSE_TYPE_SUB);
    }

    public function subCourse()
    {
        return $this->hasOne(__CLASS__, 'parent_course_id')
            ->where('type', DBConstant::COURSE_TYPE_SUB);
    }

    public function courseParent()
    {
        return $this->belongsTo(__CLASS__, 'parent_course_id');
    }

    public function extensions()
    {
        return $this->hasMany(__CLASS__, 'parent_course_id', 'course_id')
            ->where('type', DBConstant::COURSE_TYPE_EXTENSION);
    }

    public function extensionsPreview()
    {
        return $this->hasMany(__CLASS__, 'parent_course_id', 'course_id')
            ->where('type', DBConstant::COURSE_TYPE_EXTENSION)
            ->where('is_hidden', DBConstant::COURSE_IS_HIDDEN_OPEN);
    }

    public function extensionsOpen()
    {
        return $this->hasMany(__CLASS__, 'parent_course_id', 'course_id')
            ->where([
                'type' => DBConstant::COURSE_TYPE_EXTENSION,
                'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
            ])
            ->whereIn('status', [DBConstant::COURSE_STATUS_OPEN, DBConstant::COURSE_STATUS_PREVIEW]);
    }

    public function allExtensions()
    {
        return $this->hasMany(__CLASS__, 'parent_course_id', 'course_id')
            ->where([
                'type' => DBConstant::COURSE_TYPE_EXTENSION,
                'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
            ])
            ->whereIn('status', [DBConstant::COURSE_STATUS_OPEN, DBConstant::COURSE_STATUS_PREVIEW, DBConstant::COURSE_STATUS_DRAFT]);
    }

    /**
     * Course extension open and draft.
     *
     * @return HasMany
     */
    public function extensionOpenAndDraft()
    {
        return $this->hasMany(__CLASS__, 'parent_course_id', 'course_id')
            ->where([
                'type' => DBConstant::COURSE_TYPE_EXTENSION,
                'is_hidden' => DBConstant::COURSE_IS_HIDDEN_OPEN
            ])
            ->whereIn('status', [DBConstant::COURSE_STATUS_OPEN, DBConstant::COURSE_STATUS_DRAFT]);
    }
}
