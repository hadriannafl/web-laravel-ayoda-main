<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 15, 2)->default(0);
            $table->string('m_currency')->nullable();
            $table->decimal('minimum_order_qty', 15, 2)->default(0);
            $table->decimal('order_qty', 15, 2)->default(0);
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_products');
    }
};
