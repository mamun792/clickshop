<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'from_account_id',
        'to_account_id',
        'transfer_amount',
        'transfer_date',
        'user_id',
        'comments',
        'transaction_type',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class,  'id');
    }

    public function account_types()
    {
        return $this->belongsTo(AccountType::class,  'id'); // Adjust foreign key and local key
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fromAccount()
    {
        return $this->belongsTo(AccountType::class, 'from_account_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(AccountType::class, 'to_account_id');
    }
}
