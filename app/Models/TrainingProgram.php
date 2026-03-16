<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'trainer_id',
        'title',
        'type',
        'level',
        'duration_weeks',
        'exercises',
        'schedule',
        'goals',
        'notes',
        'status',
    ];

    protected $casts = [
        'exercises' => 'array',
        'schedule' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
