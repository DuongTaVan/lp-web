<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Message.
 *
 * @package namespace App\Models;
 */
class Message extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'promotional_message_id', 'to_user_id', 'is_read', 'created_at', 'updated_at',
    ];

    public function promotionalMessage()
    {
        return $this->belongsTo(PromotionalMessage::class, 'promotional_message_id')->withDefault();
    }
}
