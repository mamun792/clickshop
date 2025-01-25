<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteInfo extends Model
{
    protected $fillable = [
        'app_name',
        'home_page_title',
        'product_page_title',
        'phone_number',
        'whatsapp_number',
        'address',
        'store_gateway_image',
        'store_phone_number',
        'store_email',
        'facebook_url',
        'tiktok_url',
        'youtube_url',
        'instagram_url',
        'x_url',
        'enable_facebook_login',
        'enable_google_login',
        'shipping_charge_inside_dhaka',
        'shipping_charge_outside_dhaka',
        'quantity_indicator',
        'checkout_page_text',

    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($siteInfo) {
            foreach ($siteInfo->getDirty() as $column => $value) {
                Cache::forget("site_info_{$column}");
            }
        });
    }


}
