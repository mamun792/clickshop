<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{


    protected $fillable = [
        'client_id',
        'client_secret',
        'username',
        'password',
        'access_token',
        'refresh_token',
        'expires_at',
        'StoreId',
        'is_enabled'
    ];


}
