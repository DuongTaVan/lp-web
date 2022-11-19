<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PromotionalMessage.
 */
class StripeLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stripe_logs';

    protected $fillable = ['balance', 'type', 'payout_id'];
}
