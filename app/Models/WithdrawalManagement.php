<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalManagement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'fee',
        'min_amount',
    ];
}
