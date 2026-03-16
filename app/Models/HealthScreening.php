<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthScreening extends Model
{
    protected $fillable = [
        'user_id',
        'parq_passed',
        'parq_answers',
        'acsm_risk_class',
        'acsm_answers',
        'expires_at'
    ];

    protected $casts = [
        'parq_answers' => 'array',
        'acsm_answers' => 'array',
        'expires_at' => 'date',
        'parq_passed' => 'boolean'
    ];
}
