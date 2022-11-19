<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = "bank_accounts";

    protected $fillable = [
        'user_id', 'bank_name', 'branch_name', 'account_type', 'account_number', 'account_name'
    ];
}
