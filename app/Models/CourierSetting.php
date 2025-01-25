<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierSetting extends Model
{
    
    protected $fillable = ['api_key', 'secret_key',  'pathao_client_id', 'pathao_client_secret', 'pathao_secret_token', 'pathao_store_id', 'pathao_store_name', 'redx_sandbox', 'redx_access_token', 'pathao', 'steadfast', 'redx'];

    // set the default value of is_active to true
  

    
}
