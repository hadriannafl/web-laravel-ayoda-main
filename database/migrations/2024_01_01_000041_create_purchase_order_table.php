<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->id();
            $table->string('idpo')->unique();
            $table->date('datepo')->nullable();
            $table->date('deliverydate')->nullable();
            $table->unsignedBigInteger('idsupplier')->nullable();
            $table->integer('idwarehouse')->default(1);
            $table->string('category')->nullable();
            $table->decimal('crossrate', 15, 4)->default(1);
            $table->string('pterm')->nullable();
            $table->decimal('pvat', 5, 2)->default(0);
            $table->decimal('avat', 15, 2)->default(0);
            $table->string('currency')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('gtotal', 15, 2)->default(0);
            $table->string('status')->default('Pending');
            $table->string('addedby')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order');
    }
};
