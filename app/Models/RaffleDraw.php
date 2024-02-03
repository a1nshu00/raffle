<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaffleDraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'draw_title',
        'type',
        'total_balls',
        'buying_amount',
        'draw_time',
        'streaming_link',
        'status',
    ];
}
