<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'club_id',
        'first_name',
        'last_name',
        'second_name',
        'tc_no',
        'birth_date',
        'gender',
        'phone',
        'home_phone',
        'email',
        'email2',
        'email_notification',
        'sms_notification',
        'call_notification',
        'kvkk_approval',
        'consultant_id',
        'status',
        'type',
        'source',
        'special_code',
        'category',
        'special_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'kvkk_approval' => 'boolean',
    ];

    /**
     * Get the user that owns the member profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the trainer who added the member.
     */
    public function consultant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    /**
     * Get the user's full name.
     */
    public function getNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get member's age
     */
    public function getAge(): int
    {
        return $this->birth_date->age;
    }

    public function personal(): HasOne
    {
        return $this->hasOne(MemberPersonalInfo::class);
    }
    public function details(): HasOne
    {
        return $this->hasOne(MemberDetails::class);
    }





    public function measurementAssignments()
    {
        return $this->hasMany(MeasurementAssignment::class, 'member_id');
    }

    public function measurementReservations()
    {
        return $this->hasMany(MeasurementReservation::class, 'member_id');
    }

    public function privateLessonRequests()
    {
        return $this->hasMany(PrivateLessonRequest::class, 'member_id');
    }

    public function trainingPrograms()
    {
        return $this->hasMany(TrainingProgram::class, 'member_id');
    }
    /*
    |--------------------------------------------------------------------------
    | İLİŞKİLER VE METOTLAR (GELECEKTE KULLANMAK İÇİN YORUMDA)
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki ilişkiler ve metotlar, henüz projenizde var olmayan modellere
    | veya tablo sütunlarına referans verdiği için geçici olarak devre dışı bırakılmıştır.
    | İlgili özellikleri eklediğinizde bu yorum satırlarını kaldırabilirsiniz.
    |
    */

    /*
    public function branch(): BelongsTo
    {
        // Bu ilişki için App\Models\Club modeline ihtiyacınız var.
        return $this->belongsTo(Club::class, 'club_id');
    }

    public function packages(): HasMany
    {
        // Bu ilişki için App\Models\MemberPackage modeline ihtiyacınız var.
        return $this->hasMany(MemberPackage::class);
    }

    public function contracts(): HasMany
    {
        // Bu ilişki için App\Models\MemberContract modeline ihtiyacınız var.
        return $this->hasMany(MemberContract::class)->where('status', 1);
    }

    // ... Diğer tüm ilişkileri ve hata verebilecek metotları da bu şekilde yorum satırı yapın ...

    public function isMembershipActive(): bool
    {
        // Bu metot, 'membership_status' ve 'membership_end_date' sütunlarına ihtiyaç duyar.
        // Bu sütunlar members tablonuzda mevcut değil.
        return $this->membership_status === 'active' &&
               $this->membership_end_date >= now();
    }
    */
}
