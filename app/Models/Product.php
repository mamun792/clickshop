<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use sluggable;
    //
    protected $guarded = [];

    protected $casts = [
        'gallery_images' => 'array',
    ];


    protected static function boot()
    {
        parent::boot();

        // Invalidate cache when a product is created, updated, or deleted
        static::created(function () {
            Cache::forget('stock_report_page_1'); 
        });

        static::updated(function () {
            Cache::forget('stock_report_page_1'); // Invalidate cache for page 1
        });

        static::deleted(function () {
            Cache::forget('stock_report_page_1'); // Invalidate cache for page 1
        });

        // Also invalidate cache for any product attribute changes
        static::updated(function () {
            Cache::forget('stock_report_page_1');
        });
    }


    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_product');
    }



    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class, 'product_campaign', 'product_id', 'campaign_id');
    }

    public function product_campaign()
    {
        return $this->hasOne(ProductCampaign::class, 'product_id', 'id')->with('campaign');
    }



    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'product_name'
            ]
        ];
    }



    public function product_attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }
    public function product_attributes_combaine()
    {
        return $this->hasMany(ProductAttributeCombination::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }

    public function productCampaign()
    {
        return $this->hasOne(ProductCampaign::class, 'product_id', 'id'); // Change to 'productCampaign' here
    }

    public function options()
    {
        // return $this->hasMany(AttributeOption::class, 'attribute_id', 'attribute_id');
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }



    public function attributess()
    {
        return $this->hasMany(Attribute::class, 'product_id');
    }

    public function productCampaigns()
    {
        return $this->hasOne(ProductCampaign::class);  // Correct relationship for product campaign
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }

    // In Product.php
    public function campaign()
    {
        return $this->belongsToMany(Campaign::class, 'product_campaign');
    }


    public function productOptions()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id');
    }



    public function combinations()
    {
        return $this->hasMany(ProductAttributeCombination::class);
    }

}
