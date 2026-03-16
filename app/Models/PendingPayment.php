<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingPayment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pending_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'merchant_oid',
        'user_id',
        'package_id',
        'document_path',
        'status',
    ];

    /**
     * Bu bekleyen ödemenin ait olduğu kullanıcıyı getirir.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bu bekleyen ödemenin ait olduğu paketi getirir.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
