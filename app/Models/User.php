<?php

namespace App\Models;

use App\Enums\Constant;
use App\Enums\DBConstant;
use App\Traits\ManageFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User.
 *
 * @package namespace App\Models;
 */
class User extends Authenticatable implements Transformable
{
    use TransformableTrait, ManageFile;

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
    protected $fillable = [
        'user_type', 'teacher_type', 'teacher_category_skills', 'teacher_category_consultation', 'list_background_remove',
        'teacher_category_fortunetelling', 'corporation_id', 'login_type', 'email', 'password', 'remember_token',
        'line_id', 'facebook_id', 'google_id', 'nickname', 'last_name_kanji', 'first_name_kanji', 'last_name_kana', 'first_name_kana', 'name_use',
        'date_of_birth', 'sex', 'profile_image', 'address', 'business_name', 'business_name_kana', 'catchphrase', 'biography',
        'str_customer_id', 'cash_balance', 'points_balance', 'identity_verification_status', 'identity_verification_type', 'qualifications',
        'business_card_verification_status', 'nda_status', 'last_login', 'registration_status', 'is_archived', 'archive_reason', 'rank_id',
        'connect_verification_session', 'connect_verification_read', 'name_use', 'archive_reason_text', 'user_status', 'new_service'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Get the user type text.
     *
     * @return string
     */
    public function getUserTypeTextAttribute()
    {
        if (array_key_exists($this->user_type, Constant::USER_TYPE_TEXT)) {
            return Constant::USER_TYPE_TEXT[$this->user_type];
        }

        return null;
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
     * Get the login type text.
     *
     * @return string
     */
    public function getLoginTypeTextAttribute()
    {
        if (array_key_exists($this->login_type, Constant::LOGIN_TYPE_TEXT)) {
            return Constant::LOGIN_TYPE_TEXT[$this->login_type];
        }

        return null;
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
     * Get the year of birth.
     *
     * @return string
     */
    public function getYearOfBirthAttribute()
    {
        return now()->parse($this->date_of_birth)->format('Y') ?? null;
    }

    /**
     * Get the account type text.
     *
     * @return string
     */
    public function getAccountTypeTextAttribute()
    {
        if (array_key_exists($this->account_type, Constant::ACCOUNT_TYPE_TEXT)) {
            return Constant::ACCOUNT_TYPE_TEXT[$this->account_type];
        }

        return null;
    }

    /**
     * Get the full profile image with signed.
     *
     * @param $value
     *
     * @return string
     */
    public function getProfileImageAttribute($value)
    {
        $defaultImg = asset('assets/img/clients/header-common/not-login.svg');
        if (Route::currentRouteName() == 'portal.user.detail') {
            $defaultImg = asset('assets/img/portal/default-image.svg');
        }
        return $this->getS3FileUrl($value) ?? $defaultImg;
    }

    /**
     * Get url image type = identity verication and display order = 0 of user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imagePathType1()
    {
        return $this->hasOne(ImagePath::class, 'user_id')->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'display_order' => DBConstant::IDENTITY_VERIFICATION_DISPLAY_FIRST]);
    }

    /**
     * Get url image type = identity verication of user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imagePathAllType()
    {
        return $this->hasMany(ImagePath::class, 'user_id')->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION]);
    }

    /**
     * Get url image type = business card of user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imagePathType2()
    {
        return $this->hasOne(ImagePath::class, 'user_id')->where('type', DBConstant::IMAGE_TYPE_BUSINESS_CARD);
    }

    /**
     * Get url image type = identity verication and display order = 1 of user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function imagePathTypeDisplayOne()
    {
        return $this->hasOne(ImagePath::class, 'user_id')->where(['type' => DBConstant::IMAGE_TYPE_IDENTITY_VERIFICATION, 'display_order' => DBConstant::IDENTITY_VERIFICATION_DISPLAY_LAST]);
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name', 'current_age', 'profile_image', 'sex_text', 'profile_thumbnail'
    ];

    /**
     * Get profile thumbnail image.
     *
     * @param $value
     * @return string|void
     */
    public function getProfileThumbnailAttribute($value)
    {
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
     * Get age user.
     *
     * @return string
     */
    public function getCurrentAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }

    /**
     * Get dist_method user.
     *
     * @return integer
     */
    public function getDistMethodAttribute()
    {
        switch (true) {
            case $this->teacher_category_skills === DBConstant::TEACHER_CATEGORY_SKILLS:
                return DBConstant::DIST_METHOD_LIVE_STREAMING;
            case $this->teacher_category_consultation === DBConstant::TEACHER_CATEGORY_CONSULTATION:
            case $this->teacher_category_fortunetelling === DBConstant::TEACHER_CATEGORY_FORTUNETELLING:
                return DBConstant::DIST_METHOD_LIVE_VIDEO_CALL;
            default:
                return 0;
        }
    }

    public function getTeacherCategoryAttribute()
    {
        if ($this->teacher_category_skills) {
            return DBConstant::CATEGORY_TYPE_SKILLS;
        }
        if ($this->teacher_category_consultation) {
            return DBConstant::CATEGORY_TYPE_CONSULTATION;
        }

        return DBConstant::CATEGORY_TYPE_FORTUNETELLING;
    }

    /**
     * Get the rank that owns the user.
     */
    public function rank()
    {
        if ($this->user_type == DBConstant::USER_TYPE_TEACHER) {
            return $this->belongsTo(Rank::class, 'rank_id');
        }

        return null;
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class, 'user_id', 'user_id');
    }
}
