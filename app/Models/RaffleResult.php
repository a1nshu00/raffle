<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'prize_id',
        'raffle_id',
        'order_id',
        'winning_ball',
        'user_choice',
    ];
}
