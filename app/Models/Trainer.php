<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'tc_no',
        'specialization',
        'certification',
        'experience_years',
        'hourly_rate',
        'availability',
        'status',
        'notes'
    ];
    protected $casts = [
        'certification' => 'array', // certification sütununu dizi olarak kullan
        'availability' => 'array',
    ];
    /**
     * Bu eğitmen profilinin ait olduğu kullanıcıyı getirir.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
