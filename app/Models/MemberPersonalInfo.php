<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberPersonalInfo extends Model
{
    use HasFactory;

    protected $table = 'member_personal_infos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_id',
        'weight',               // EKLENDİ
        'height',               // EKLENDİ
        'hobbies',
        'body_size',
        'special_condition',
        'step_goal',
        'other_personal_info',  // Sondaki tırnak işareti kaldırıldı
        'target_areas',
        // Migration'daki diğer alanlar da eklenebilir
        'gender',
        'blood_type',
        'birth_place',
        'birth_date',
        'education',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'hobbies' => 'array',
        'special_condition' => 'array',
        'other_personal_info' => 'array',
        'target_areas' => 'array',
        'birth_date' => 'date', // birth_date'i de cast etmek iyi bir pratiktir
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
