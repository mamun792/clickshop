<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmtpSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'email_from', 'email_from_name', 'contact_email',
        'smtp_host', 'smtp_port', 'smtp_encryption', 'smtp_username', 'smtp_password'
    ];
}
