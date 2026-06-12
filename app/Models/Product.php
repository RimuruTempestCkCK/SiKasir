<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'category_id', 'name', 'purchase_price', 'selling_price', 'stock', 'photo'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockLogs()
    {
        return $this->hasMany(StockLog::class);
    }
}
