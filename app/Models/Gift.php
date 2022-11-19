<?php

namespace App\Models;

use App\Traits\ManageFile;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class GiftTippingHistory.
 *
 * @package namespace App\Models;
 */
class Gift extends Model implements Transformable
{
    use TransformableTrait, ManageFile;

    protected $table = "gifts";

    protected $appends = [
        'image'
    ];

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'gift_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'price', 'points_equivalent', 'image_url', 'display_order'];

    public function getImageAttribute()
    {
        return $this->getS3FileUrl($this->image_url) ?? asset('assets/img/portal/default-image.svg');
    }
}
