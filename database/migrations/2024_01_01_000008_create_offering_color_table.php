<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offering_color', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_color');
            $table->string('color_tag');
            $table->unsignedBigInteger('add_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offering_color');
    }
};
