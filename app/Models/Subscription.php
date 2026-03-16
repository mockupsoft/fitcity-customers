<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'paytr_token',
        'status',
        'starts_at',
        'ends_at',
        'next_billing_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'next_billing_date' => 'date',
    ];

    /**
     * Bu aboneliğin ait olduğu kullanıcıyı getirir.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bu aboneliğin ait olduğu paketi getirir.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
