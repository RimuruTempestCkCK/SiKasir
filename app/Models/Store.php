<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['user_id', 'name', 'address', 'phone', 'type', 'logo'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cashiers()
    {
        return $this->hasMany(User::class, 'store_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
