<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MarketingTool extends Model
{
    use  hasFactory;

    protected $fillable = ['name', 'identifier', 'script'];
}
