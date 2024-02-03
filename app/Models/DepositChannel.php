<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositChannel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'channel_type',
        'account_name',
        'account_number',
        'bank_name',
        'qr_code',
        'e_wallet_account_number',
        'IFSC_code',
        'fee',
        'fee_type',
        'min_amount',
    ];
}
