<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'city',
        'phone',
        'type',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
