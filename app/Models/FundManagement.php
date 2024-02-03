<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundManagement extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'wallet_id',
        'fund_type',
        'fund_time',
    ];
}
