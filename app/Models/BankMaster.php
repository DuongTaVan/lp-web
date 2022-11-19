<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Statistic.
 *
 * @package namespace App\Models;
 */
class BankMaster extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "bank_masters";

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
        'code', 'name', 'parent_id', 'type'
    ];

}
