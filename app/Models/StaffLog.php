<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'activity_name',
        'message',
        'log_time',
    ];
}
