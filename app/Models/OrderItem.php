<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'coupon_id',
        'code',
        'discount',
        'discount_type',
        'campaign_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationship to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship to Coupon (if needed)
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    // Relationship to Campaign (if needed)
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }


    //

    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }

    // public function attributeOptions()
    // {
    //     return $this->hasMany(AttributeOption::class, 'id', 'attribute_options_id');
    // }

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_options_id');
    }

    public function option()
    {
        return $this->hasMany(OrderItemOption::class, 'order_item_id');
    }

    public function product_info()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function product_attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'product_id');
    }










    public function orderItemOptions(): HasMany
    {
        return $this->hasMany(OrderItemOption::class);
    }

    public function attributeOptions()
    {
        return $this->belongsToMany(
            AttributeOption::class,
            'order_item_options',
            'order_item_id',
            'attribute_options_id'
        );
    }







}
