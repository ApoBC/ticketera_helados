<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category',
        'base_price',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
    // Agrega este accessor al final de la clase
public function getFormattedPriceAttribute()
{
    return 'S/ ' . number_format($this->base_price, 2);
}
}