<?php

namespace App\Models;

use App\Enums\Constant;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class UserPoint.
 *
 * @package namespace App\Models;
 */
class UserPoint extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "user_points";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'user_point_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'deposit_points', 'deposit_reason', 'withdrawal_points', 'withdrawal_reason',
        'points_balance', 'transacted_at', 'consumed_points', 'is_consumed',
        'expiration_date', 'is_processed', 'expired_user_point_id', 'review_id'
    ];

    /**
     * Get the business card verification status text.
     *
     * @return string
     */
    public function getIsConsumedTextAttribute()
    {
        if (array_key_exists($this->business_card_verification_status, Constant::IS_CONSUMED)) {
            return Constant::IS_CONSUMED[$this->business_card_verification_status];
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
        if (array_key_exists($this->nda_status, Constant::IS_PROCESSED)) {
            return Constant::IS_PROCESSED[$this->nda_status];
        }

        return null;
    }
}
