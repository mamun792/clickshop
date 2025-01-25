<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeVariant extends Model
{
    protected $fillable = [
        'product_id',
        'attribute_id',
        'value',
        'additional_price',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
