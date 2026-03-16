<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'trainer_id', 'type', 'level', 'capacity',
        'duration_minutes', 'class_date', 'start_time', 'end_time', 'status'
    ];

    protected $casts = [
        'class_date' => 'date',
    ];

    /**
     * Dersi veren eğitmeni (User) getirir.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
