<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Products'; // important since your table is capitalized

    protected $fillable = [
        'product_name',
        'product_price',
        'product_size',
        'product_stock',
        'product_status',
    ];
}
