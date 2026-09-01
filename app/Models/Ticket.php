<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'customer_name',
        'total',
        'status',
        'user_id',
    ];

    protected $casts = [
        'total' => 'decimal:2',
    ];

    // Relación: un ticket tiene muchos items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relación: un ticket fue registrado por un usuario (trabajador/admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Agrega este accessor
public function getFormattedTotalAttribute()
{
    return 'S/ ' . number_format($this->total, 2);
}
}