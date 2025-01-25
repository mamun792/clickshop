<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseGroup extends Model
{
    //

    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id'); // Correct foreign key
    }

    public function supplier()
    {
        return $this->purchase->supplier(); // Access supplier through purchase
    }
    
}
