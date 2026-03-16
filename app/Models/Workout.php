<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workout extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $fillable = [
        'workout_category_id',
        'workout_type_id',
        'trainer_id',
        'name',
        'description',
        'video_path',
        'muscle_group_image_path',
        'duration_minutes',
        'status',
        'view_count', // EKLENDİ
    ];
    /**
     * Bu antrenmanın ait olduğu kategoriyi getirir.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkoutCategory::class, 'workout_category_id');
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(WorkoutType::class, 'workout_type_id');
    }
    /**
     * Bu antrenmanı yükleyen eğitmeni (User) getirir.
     */
    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
    public function getMuscleGroupImageUrlAttribute(): string
    {
        // Eğer resim yolu varsa, portalın tam URL'si ile birleştir.
        // Yoksa, varsayılan bir resim URL'si döndür.
        if ($this->muscle_group_image_path) {
            // BURADAKİ URL'İ KENDİ PORTAL ADRESİNİZLE DEĞİŞTİRİN
            return 'https://portal.fitcity.com.tr/storage/' . $this->muscle_group_image_path;
        }

        return asset('img/default-workout.png');
    }

    /**
     * Videonun tam URL'sini döndürür.
     */
    public function getVideoUrlAttribute(): string
    {
        if ($this->video_path) {
            // BURADAKİ URL'İ KENDİ PORTAL ADRESİNİZLE DEĞİŞTİRİN
            return 'https://portal.fitcity.com.tr/storage/' . $this->video_path;
        }

        return '';
    }

}
