<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;


class Order extends Model
{
    protected $fillable = [
        'user_identifier',
        'customer_name',
        'address',
        'phone_number',
        'alternative_phone_number',
        'email',
        'note',
        'order_status',
        'order_type',
        'total_price',
        'shipping_price',
        'delivery',
        'delivery_charge',
        'invoice_number',
        'comment_id',
        'consignment_id',
        'tracking_code',
        'couriar_status',
        'couriar_name',
        'city_id',
        'zone_id',
        'area_id',
        'city_name',
        'zone_name',
        'area_name',
        'courier_note',
        'discount'


    ];


    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('all_orders_with_details');
        });

        static::updated(function () {
            Cache::forget('all_orders_with_details');
        });

        static::deleted(function () {
            Cache::forget('all_orders_with_details');
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer_info(){
        return $this->belongsTo(User::class, 'user_identifier', 'id');
    }

    public function customer_address(){
        return $this->belongsTo(UserAddress::class, 'user_identifier', 'user_id');
    }

    public function comment(){
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }


}
