<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'category_id', 'name', 'purchase_price', 'selling_price', 'stock', 'photo'];

    public static function generateInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        if (count($words) >= 2) {
            $initials = substr($words[0], 0, 1) . substr($words[1], 0, 1);
        } else {
            $initials = substr($name, 0, 2);
        }
        return strtoupper($initials);
    }

    public static function generatePlaceholderColor($name)
    {
        $colors = ['#5f76e8', '#ff4f70', '#01caf1', '#ffb22b', '#22ca80', '#a1a8b7', '#6c757d', '#343a40'];
        $hash = md5($name);
        $index = hexdec(substr($hash, 0, 2)) % count($colors);
        return $colors[$index];
    }

    public function getInitialsAttribute()
    {
        return self::generateInitials($this->name);
    }

    public function getPlaceholderColorAttribute()
    {
        return self::generatePlaceholderColor($this->name);
    }

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
