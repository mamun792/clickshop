<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponProduct extends Model
{
    use HasFactory;

    // Table name (optional if it matches the pluralized form of the model name)
    protected $table = 'coupon_product';

    // Primary key (optional if it follows Laravel's conventions)
    protected $primaryKey = 'id';

    // Whether the primary key is auto-incrementing
    public $incrementing = true;

    // Data type of the primary key
    protected $keyType = 'unsignedBigInteger';

    // Disabling timestamps if you don't want Laravel to manage created_at and updated_at automatically
    public $timestamps = true;

    // Mass assignable attributes
    protected $fillable = [
        'product_id',
        'coupon_id',
        'created_at',
        'updated_at',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
