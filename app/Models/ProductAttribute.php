<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Models\Notification;



class ProductAttribute extends Model
{


    protected static function booted()
    {
        static::updated(function ($productAttribute) {
            if ($productAttribute->quantity == 0 && $productAttribute->getOriginal('quantity') > 0) {
                Notification::create([
                    'user_id' => $productAttribute->user_id, // Add the actual user reference
                    'notification_type' => 'product',
                    'related_id' => $productAttribute->id,
                    'message' => "Product attribute {$productAttribute->id} is out of stock.",
                ]);
            }
        });
    }

    //
   // protected $guarded = [];

    protected $fillable = [
        'product_id', 'attribute_id', 'attribute_option_id', 'quantity', 'price', 'sold_quantity', 'status','combination_id'
    ];


    protected static function boot()
    {
        parent::boot();

        // Invalidate cache when product attribute is created, updated, or deleted
        static::created(function () {
            Cache::forget('stock_report_page_1');
        });

        static::updated(function () {
            Cache::forget('stock_report_page_1');
        });

        static::deleted(function () {
            Cache::forget('stock_report_page_1');
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'attribute_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function attribute_option()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id', 'id');
    }




    // Belongs to an attribute option
    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id', 'id');
    }

    public function productAttributeCombaine()
    {
        return $this->hasMany(ProductAttributeCombination::class);
    }



    public function option()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id');
    }




}
