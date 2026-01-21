<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'total_amount',
        'status',
        'order_date'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    // Relationship: Order has many OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relationship: Order belongs to User (optional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper: Get all products in this order
    public function products()
    {
        return $this->hasManyThrough(Product::class, OrderItem::class);
    }
}
