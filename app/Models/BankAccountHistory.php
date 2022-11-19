<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccountHistory extends Model
{
    protected $table = "bank_account_histories";

    protected $fillable = [
        'user_id', 'old_id', 'bank_name', 'branch_name', 'account_type', 'account_number', 'account_name'
    ];

    /**
     * Get the user that owns the course.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
