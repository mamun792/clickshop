<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;



    protected $fillable = [
        'code',
        'discount_type',
        'discount_amount',
        'valid_from',
        'expiry_date',
        'usage_limit',
        'used_count'
    ];


    protected $casts = [
        'valid_from' => 'date',
        'expiry_date' => 'date',
        'discount_amount' => 'decimal:2',
        'used_count' => 'integer',
        'usage_limit' => 'integer',
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_product');
    }
}
