<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sale_price',
        'stock',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
