<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItemOption extends Model
{
    protected $fillable = ['order_item_id', 'attribute_options_id', 'quantity'];
    protected $guarded = [];


    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    // public function attributeOption()
    // {
    //     return $this->belongsTo(AttributeOption::class);
    // }

    public function attributeOption()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_options_id');
    }

    public function options()
    {
        return $this->hasMany(OrderItemOption::class);
    }

    
}
