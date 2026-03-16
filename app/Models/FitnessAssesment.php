<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessAssessment extends Model
{
    protected $fillable = [
        'member_id',
        'trainer_id',
        'type', // static_posture, dynamic_posture, mobility, strength, vo2max
        'data',
        'results'
    ];

    protected $casts = [
        'data' => 'array',
        'results' => 'array'
    ];
}
