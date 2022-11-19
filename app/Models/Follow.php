<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';

    protected $primaryKey = 'from_user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['from_user_id', 'to_user_id', 'teacher_repeat_count', 'last_purchased_at'];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name', 'current_age', 'sex_text'
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
     * Get age user.
     *
     * @return string
     */
    public function getCurrentAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
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
}
