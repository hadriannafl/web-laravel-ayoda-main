<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_assets', function (Blueprint $table) {
            $table->id('idassets');
            $table->string('name');
            $table->string('unit')->nullable();
            $table->string('category')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->string('location')->nullable();
            $table->string('status')->default('Available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_assets');
    }
};
