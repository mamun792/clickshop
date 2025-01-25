<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartAttribute extends Model
{
    protected $table = 'cart_attributes';

    protected $fillable = ['cart_id', 'attribute_options_id','product_attr_id'];



    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }


    // attribute value is option value
    // In CartAttribute model
    public function carts()
    {
        return $this->belongsTo(Cart::class, 'cart_id'); // Adjust as per actual foreign key
    }

    // In CartAttribute model
    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_options_id'); // Adjust the foreign key as necessary
    }



public function attributes()
{
    return $this->hasOneThrough(
        Attribute::class,
        AttributeOption::class,
        'id',         
        'id',         
        'attribute_options_id',
        'attribute_id' 
    );
}

public function productAttribute()
{
    return $this->belongsTo(ProductAttribute::class, 'attribute_options_id', 'attribute_option_id');
}


}
