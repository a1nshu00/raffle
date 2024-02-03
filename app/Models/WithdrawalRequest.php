<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'channel_id',
        'amount',
        'screenshot',
        'status',
        'fee',
        'account_name',
        'account_number',
        'qr_code',
        'bank_name',
        'remarks',
    ];
}
