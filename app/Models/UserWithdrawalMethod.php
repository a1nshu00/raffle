<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWithdrawalMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'method_id',
        'account_name',
        'account_number',
        'qr_code',
        'bank_name',
    ];
}
