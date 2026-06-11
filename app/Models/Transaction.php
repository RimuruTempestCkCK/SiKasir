<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['store_id', 'user_id', 'invoice_number', 'total_price', 'amount_paid', 'change'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
