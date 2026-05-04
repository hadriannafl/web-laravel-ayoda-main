<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_order_detail', function (Blueprint $table) {
            $table->id();
            $table->string('idpo');
            $table->integer('no')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->decimal('quantity', 15, 2)->default(0);
            $table->string('unit')->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_detail');
    }
};
