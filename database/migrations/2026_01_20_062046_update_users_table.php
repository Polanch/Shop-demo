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
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('username')->unique()->after('email');
            $table->string('role')->default('user')->after('username');
            
            // Remove the name column
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse: add back the name column
            $table->string('name');
            
            // Reverse: remove the new columns
            $table->dropColumn(['username', 'role']);
        });
    }
};