<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeasurementAssignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'assignment_date' => 'datetime',
        'expiration_date' => 'datetime', // Bu satır hatayı çözer
        'completed_at' => 'datetime',
    ];

    /**
     * Bu atamanın hangi ölçüm türü için olduğunu belirtir.
     */
    public function measurement(): BelongsTo
    {
        return $this->belongsTo(Measurement::class);
    }
}
