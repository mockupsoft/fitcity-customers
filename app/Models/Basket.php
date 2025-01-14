<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Basket extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ="basket";

    public function getProduct()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
