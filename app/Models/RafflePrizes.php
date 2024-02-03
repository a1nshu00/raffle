<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RafflePrizes extends Model
{
    use HasFactory;
    protected $fillable = [
        'raffle_id',
        'prize_name',
        'physical_prize_image',
        'cash_prize',
        'physical_prize',
        'admin_fee',
    ];
}
