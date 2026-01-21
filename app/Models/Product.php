<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // lowercase for PostgreSQL compatibility

    protected $fillable = [
        'product_name',
        'product_price',
        'product_size',
        'product_stock',
        'product_status',
        'pictures',
    ];
}
