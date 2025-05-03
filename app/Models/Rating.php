<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'cleanliness', 'maintenance', 'trainers', 'friendliness', 'service', 'general', 'club_id', 'customer_id'
    ];
}
