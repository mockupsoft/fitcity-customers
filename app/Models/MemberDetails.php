<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberDetails extends Model
{
    use HasFactory;

    protected $table = 'member_details';

    protected $fillable = [
        'member_id',
        'notes', // Hedefleri bu alanda saklayacağız
        // Diğer alanlar...
    ];

    /**
     * 'notes' alanını otomatik olarak diziye çevirir.
     * @var array
     */
    protected $casts = [
        'notes' => 'array',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
