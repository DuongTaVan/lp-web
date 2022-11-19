<?php

namespace App\Models;

use App\Enums\DBConstant;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Traits\ManageFile;
use App\Enums\Constant;

/**
 * Class ImagePath.
 *
 * @package namespace App\Models;
 */
class ImagePath extends Model implements Transformable
{
    use TransformableTrait, ManageFile;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'course_id',
        'course-schedule_id',
        'file_name',
        'dir_path',
        'image_url',
        'status',
        'display_order'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'teacher_category_text', 'image_url', 'thumbnail'
    ];

    /**
     * Get the full image url with signed.
     *
     * @param $value
     * @return string
     */
    public function getImageUrlAttribute($value)
    {
        return $this->getS3FileUrl($this->dir_path . '/' . $this->file_name) ?? asset('assets/img/portal/default-image.svg');
    }

    /**
     * Get the full image url with signed.
     *
     * @return string
     */
    public function getImageS3UrlAttribute()
    {
        return $this->getS3FileUrl($this->dir_path . '/' . $this->file_name) ?? asset('assets/img/portal/default-image.svg');
    }

    /**
     * Get thumbnail image.
     *
     * @return string|void
     */
    public function getThumbnailAttribute()
    {
        $nameExt = explode(".", $this->file_name);
        if (isset($nameExt[0])) {
            return $this->getS3FileUrl('thumbnails/' . $this->dir_path . '/' . $nameExt[0] . '.jpg') ?? asset('assets/img/portal/default-image.svg');
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the teacher category text.
     *
     * @return string
     */
    public function getTeacherCategoryTextAttribute()
    {
        switch (true) {
            case $this->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS:
                return Constant::TEACHER_CATEGORY_TEXT[1];
            case $this->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION:
                return Constant::TEACHER_CATEGORY_TEXT[2];
            case $this->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING:
                return Constant::TEACHER_CATEGORY_TEXT[3];
            default:
                return null;
        }
    }
}
