<?php

namespace App\Models;

use App\Enums\Constant;
use App\Enums\DBConstant;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Purchase.
 *
 * @package namespace App\Models;
 */
class Purchase extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "purchases";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'purchase_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no', 'user_id', 'course_schedule_id', 'status', 'subtotal_amount',
        'discount_amount', 'discount_amount', 'total_amount', 'purchased_at', 'canceled_at', 'student_canceled_at'
    ];

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
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
     * Get sex name user.
     *
     * @return string
     */
    public function getSexTypeAttribute()
    {
        if (isset($this->sex) && is_numeric($this->sex)) {
            return Constant::SEX_TEXT[(string)$this->sex];
        }

        return '';
    }

    /**
     * Get settlements.
     */
    public function settlement()
    {
        return $this->hasOne(Settlement::class, 'purchase_id');
    }

    /**
     * get gift
     */
    public function gift()
    {
        return $this->belongsTo(Gift::class, 'gift_id');
    }

    /**
     * Get the user that owns the course.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
