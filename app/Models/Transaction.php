<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'purpose_id',
        'amount',
        'comments',
        'account_id',
        'transaction_type',
        'document',
    ];

    // Define relationships
    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }

    public function account()
    {
        return $this->belongsTo(AccountType::class);
    }
}
