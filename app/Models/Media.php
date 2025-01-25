<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'favicon', 'loader', 'footer_image'];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($media) {
           
            foreach ($media->getDirty() as $column => $value) {
                Cache::forget("media_{$column}");
            }
        });
    }
}
