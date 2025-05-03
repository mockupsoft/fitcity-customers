<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotentialCustomer extends Model
{
    use HasFactory;

    public function fullName()
    {
        return $this->ad . ' ' . $this->soyad;
    }

    public function getReferansUye()
    {
        return $this->hasOne(User::class,'id','referans_uye');
    }
}
