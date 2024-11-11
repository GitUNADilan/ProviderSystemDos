<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'provider_id',
        'employee_id',
        'purchase_date',
        'total',
        'is_active'
    ];

    // Scope para activos
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Relaciones
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
