<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Corporation extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "corporations";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'corporation_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_kana', 'address', 'establishment_date', 'last_name_kanji',
        'first_name_kanji', 'last_name_kana', 'first_name_kana', 'is_archived'
    ];
}
