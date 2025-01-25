<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeCombination extends Model
{
    protected $table = 'product_attribute_combinations'; // Define the table name

    protected $fillable = [
        'product_id',
        'combination_string',
        'price',
        'quantity',
    ];

    // Example of a hasMany relationship with ProductOption model
    public function options()
    {
        return $this->hasMany(ProductAttribute::class, 'combination_id');
    }
    // Define the belongsTo relationship
    public function attribute()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id', 'id');
    }
    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'combination_id', 'id');
    }

    // Optionally, if timestamps are not needed
    public $timestamps = false;
}
