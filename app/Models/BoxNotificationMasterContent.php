<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxNotificationMasterContent extends Model
{
    protected $table = "box_notification_master_contents";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'box_notification_master_content_id';

     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = ['timing_type', 'title', 'body'];
}
