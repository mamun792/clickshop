<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incomplete extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incomplete';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_identifier',
        'customer_name',
        'address',
        'phone_number',
        'alternative_phone_number',
        'email',
        'note',
        'order_status',
        'total_price',
        'shipping_price',
        'delivery_charge',
        'delivery',
        'invoice_number',
        'comment_id',
        'order_items',
    ];
    protected $casts = [
        'order_items' => 'array', // Automatically cast JSON to an array
    ];

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

    
}
