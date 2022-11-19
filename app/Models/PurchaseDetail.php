<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Purchase.
 *
 * @package namespace App\Models;
 */
class PurchaseDetail extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "purchase_details";

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
        'purchase_id', 'item', 'course_schedule_id', 'optional_extra_id', 'question_ticket_id',
        'gift_id', 'unit_price', 'quantity', 'total_amount', 'canceled_at'
    ];


    public function optionalExtra()
    {
        return $this->belongsTo(OptionalExtra::class, 'optional_extra_id');
    }
}
