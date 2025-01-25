<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    protected $guarded = [];

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }


}
