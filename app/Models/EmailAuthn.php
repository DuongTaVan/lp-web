<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class EmailAuthn extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'email_authns';

    protected $fillable = [
        'user_type', 'email', 'token'
    ];
}
