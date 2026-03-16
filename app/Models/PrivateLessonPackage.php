<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateLessonPackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', // Eklendi
        'trainer_id',
        'member_id',
        'total_sessions',
        'remaining_sessions',
        'price_per_session',
        'total_price',
        'start_date',
        'end_date',
        'status',
        'is_verified',
        'verified_by',
        'verified_at',
    ];
}
