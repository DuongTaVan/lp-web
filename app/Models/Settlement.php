<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Settlement.
 *
 * @package namespace App\Models;
 */
class Settlement extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "settlements";

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
        'purchase_id', 'str_payment_id', 'currency', 'payment_method', 'card_brand', 'payment_amount',
        'status', 'approval_failed_at', 'approval_error_reason', 'approved_at', 'approved_amount',
        'capture_failed_at', 'capture_error_reason', 'captured_at', 'captured_amount',
        'cancellation_failed_at', 'cancellation_error_reason', 'canceled_at', 'canceled_amount'
    ];

    /**
     * Get purchases from settlements table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
