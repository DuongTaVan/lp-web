<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Ranking.
 */
class Review extends Model implements Transformable
{
    use TransformableTrait;
    use ManageFile;

    protected $table = 'reviews';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public $appends = [
        'image', 'sex_text', 'full_name', 'image_course', 'current_age', 'profile_thumbnail'
    ];

    /**
     * Get profile thumbnail image.
     *
     * @param $value
     * @return string|void
     */
    public function getProfileThumbnailAttribute($value)
    {
        if (!$this->profile_image) return false;
        $nameExt = explode(".", $this->getOriginal('profile_image'));
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl('thumbnails' . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/clients/header-common/not-login.svg');
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'course_schedule_id', 'rating', 'comment', 'is_public'];

    public function getImageCourseAttribute()
    {
        if (!$this->file_name) return asset('assets/img/portal/default-image.svg');
        $nameExt = explode(".", $this->file_name);
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl('thumbnails/' . $this->dir_path . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/portal/default-image.svg');
        }
    }

    /**
     * Get the user that owns the review.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the course Schedule schedule that owns the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseSchedule()
    {
        return $this->belongsTo(CourseSchedule::class, 'course_schedule_id');
    }

    public function getImageAttribute()
    {
        return $this->getS3FileUrl($this->profile_image) ?? asset('assets/img/clients/course-detail/avt.png');
    }

    /**
     * Get the sex text.
     *
     * @return string
     */
    public function getSexTextAttribute()
    {
        if (array_key_exists($this->sex, Constant::SEX_TEXT)) {
            return Constant::SEX_TEXT[$this->sex];
        }

        return null;
    }

    /**
     * Get full name user.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        if ($this->user_type == DBConstant::USER_TEACHER && $this->name_use == DBConstant::USER_REALNAME) {
            return "{$this->last_name_kanji}{$this->first_name_kanji}";
        }

        return $this->nickname;
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
}
