<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['type', 'content', 'is_published'];

    const TYPES = [
        'POLICIES' => 'policies',
        'TERMS' => 'terms',
        'REFUND' => 'refund',
        'SALES_SUPPORT' => 'sales_support',
        'SHIPPING_DELIVERY' => 'shipping_delivery',
    ];
}
