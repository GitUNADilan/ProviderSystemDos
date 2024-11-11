<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'client_id',
        'seller_id',
        'date_sale',
        'total',
        'is_active'
    ];

    // Scope para activos
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function seller()
    {
        return $this->belongsTo(Employee::class, 'seller_id');
    }

    public function details()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
