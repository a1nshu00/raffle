<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'channel_id',
        'amount',
        'screenshot',
        'status',
        'fee',
        'remarks',
    ];
}
