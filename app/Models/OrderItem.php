<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_purchase',
        'subtotal'
    ];

    protected $casts = [
        'price_at_purchase' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Relationship: OrderItem belongs to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship: OrderItem belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
