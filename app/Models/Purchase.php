<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function purchase_group(){
        return $this->hasMany(PurchaseGroup::class, 'purchase_id', 'id');
    }

    public function purchaseGroups()
    {
        return $this->hasMany(PurchaseGroup::class, 'purchase_id', 'id');
    }

   

    
}
