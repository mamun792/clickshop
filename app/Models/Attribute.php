<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    //
    protected $guarded = [];

    function attribute_option()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }

    public function options()
    {
        return $this->hasMany(AttributeOption::class, 'attribute_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');  // Foreign key is 'product_id'
    }


    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_id', 'id');
    }

    public function attributeOptions()
    {
        return $this->hasMany(AttributeOption::class);
    }
}
