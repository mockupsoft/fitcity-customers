<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clubs';

    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'website',
        'description',
        'working_hours',
        'amenities',
        'images',
        'is_active',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'amenities' => 'array',
        'images' => 'array',
        'is_active' => 'boolean',
    ];
}
