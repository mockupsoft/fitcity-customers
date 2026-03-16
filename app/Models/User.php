<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'club_id',
        'sms_code',
        'is_active',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'sms_code', // Gizli alanlara eklendi
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
        ];
    }

    public function member(): HasOne
    {
        return $this->hasOne(Member::class, 'user_id');
    }
    public function trainerDetails(): HasOne
    {
        return $this->hasOne(Trainer::class, 'user_id');
    }
    public function groupClasses(): HasMany
    {
        return $this->hasMany(GroupClass::class, 'trainer_id');
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id');
    }

    public function groupClassParticipations()
    {
        return $this->hasMany(GroupClassParticipant::class, 'member_id');
    }

    public function privateLessonPackages()
    {
        return $this->hasMany(PrivateLessonPackage::class, 'member_id');
    }
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function deviceTokens(): HasMany
    {
        return $this->hasMany(UserDeviceToken::class);
    }
}
