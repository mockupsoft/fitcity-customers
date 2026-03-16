<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity'
    ];


    public function groupClasses()
    {
        return $this->hasMany(GroupClass::class);
    }
}
