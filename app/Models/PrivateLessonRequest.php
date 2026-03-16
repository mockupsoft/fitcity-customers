<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateLessonRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'trainer_id',
        'created_by',
        'status',
        'notes',
        'lesson_date',
        'start_time',
        'end_time',
        'request_type', // Bu alana ihtiyacımız olabilir
    ];
}
