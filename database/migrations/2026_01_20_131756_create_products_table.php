<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('product_name'); // Name of the T-shirt
            $table->decimal('product_price', 8, 2); // Price, up to 999,999.99
            $table->string('product_size'); // Size: XS, S, M, L, XL, etc.
            $table->unsignedInteger('product_stock')->default(0); // Stock, max 500 handled in app logic
            $table->text('product_status')->nullable(); // Text status (e.g., available, sold out)
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
