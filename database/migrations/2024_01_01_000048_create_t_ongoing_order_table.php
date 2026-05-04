<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('t_ongoing_order', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('count')->default(0);
            $table->decimal('total', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_ongoing_order');
    }
};
