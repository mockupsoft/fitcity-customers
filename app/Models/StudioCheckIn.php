<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudioCheckIn extends Model
{
    use HasFactory;

    protected $table = 'studio_check_ins';

    protected $fillable = [
        'member_id',
        'club_id',
        'studio_name',
        'check_in_time',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
