<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Constant;

class BoxNotificationTransContent extends Model
{
    protected $table = "box_notification_trans_contents";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'box_notification_trans_content_id';

     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = ['title', 'body', 'to_type', 'scheduled_at', 'is_delivered', 'delivered_at'];

     /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'to_type_text',
        'is_delivered_text'
    ];

    /**
     * The attributes that should be cast to native types
     *
     * @var array
     */
    protected $casts = [
        'delivered_at' => 'datetime:Y/m/d H:m:s',
    ];

     /**
     * Get the to_type text.
     *
     * @return string
     */
    public function getToTypeTextAttribute()
    {
        if (array_key_exists($this->to_type, Constant::BOX_NOTIFICATION_TRANS_CONTENTS_TYPE_TEXT)) {
            return Constant::BOX_NOTIFICATION_TRANS_CONTENTS_TYPE_TEXT[$this->to_type];
        }

        return null;
    }

    /**
     * Get the is_delivered text.
     *
     * @return string
     */
    public function getIsDeliveredTextAttribute()
    {
        if (array_key_exists($this->is_delivered, Constant::BOX_NOTIFICATION_TRANS_CONTENTS_IS_DELIVERED_TEXT)) {
            return Constant::BOX_NOTIFICATION_TRANS_CONTENTS_IS_DELIVERED_TEXT[$this->is_delivered];
        }

        return null;
    }

}
