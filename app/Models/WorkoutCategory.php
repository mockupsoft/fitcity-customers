<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkoutCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Bu kategoriye ait antrenmanları getirir.
     */
    public function workouts(): HasMany
    {
        return $this->hasMany(Workout::class);
    }
}
