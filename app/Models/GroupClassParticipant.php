<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupClassParticipant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group_class_participants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_class_id',
        'member_id',
        'status',
    ];

    /**
     * Bu katılım kaydının ait olduğu grup dersini getirir.
     * Hatanın çözümü bu metottur.
     */
    public function groupClass(): BelongsTo
    {
        return $this->belongsTo(GroupClass::class, 'group_class_id');
    }

    /**
     * Bu katılım kaydını yapan üyeyi (User) getirir.
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
