<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class TransferHistory.
 *
 * @package namespace App\Models;
 */
class TransferHistory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "transfer_histories";

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
        'cash_id', 'bank_id', 'status', 'withdrawal_amount', 'transfer_fee', 'teacher_profit', 'failure_code',
        'transfer_amount', 'scheduled_date', 'transferred_at', 'str_payout_id', 'failed_at', 'approved_at'
    ];

    /**
     * Get the user that owns the course.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * Get the user that owns the course.
     */
    public function bankAccount()
    {
        return $this->belongsTo(BankAccountHistory::class, 'bank_id');
    }

}
