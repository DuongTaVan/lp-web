<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Cash.
 *
 * @package namespace App\Models;
 */
class Cash extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "cashes";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cash_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'deposit_amount', 'deposit_reason', 'sale_tax',
        'withdrawal_amount', 'withdrawal_reason', 'balance', 'transacted_at', 'teacher_profit'
    ];

}
