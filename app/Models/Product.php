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
        'stock',
        'low_stock_threshold',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock' => 'integer',
        'low_stock_threshold' => 'integer',
    ];

    /**
     * true si el producto no lleva control de stock (stock = null → "ilimitado").
     */
    public function tracksStock(): bool
    {
        return !is_null($this->stock);
    }

    public function isOutOfStock(): bool
    {
        return $this->tracksStock() && $this->stock <= 0;
    }

    public function isLowStock(): bool
    {
        return $this->tracksStock() && $this->stock > 0 && $this->stock <= $this->low_stock_threshold;
    }
    // Agrega este accessor al final de la clase
public function getFormattedPriceAttribute()
{
    return 'S/ ' . number_format($this->base_price, 2);
}

    // Relación: un producto puede aparecer en muchos items de tickets
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}