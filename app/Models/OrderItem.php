<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;   // ← Agrega esta línea

    protected $fillable = [
        'ticket_id',
        'product_id',
        'product_name',
        'options',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'options' => 'array',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}