<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductCampaign extends Pivot
{
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_campaign', 'campaign_id', 'product_id');
    }

    public function productCampaigns()
    {
        return $this->hasMany(ProductCampaign::class, 'campaign_id', 'id');
    }
}
