<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $table = 'carts';
    protected $fillable = [
        'user_identifier',
        'product_id',
        'quantity',
        'campaign_id',
        'discount_value',
        'attribute_hash'
    ];

    protected $attributes = [
        'attribute_hash' => null, 
    ];

    // Define relationship with CartAttribute if needed
    public function attributes()
    {
        return $this->hasMany(CartAttribute::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public static function getCartByUserIdentifier($userIdentifier)
    {
        return self::where('user_identifier', $userIdentifier)->get();
    }


    public static function boot()
    {
        parent::boot();

        static::saving(function ($cart) {
            if ($cart->quantity <= 0) {
                throw new \Exception('Quantity must be greater than zero.');
            }
        });
    }

    // In Cart model
public function cartAttributes()
{
    return $this->hasMany(CartAttribute::class, 'cart_id'); // Adjust as per actual foreign key
}



}
