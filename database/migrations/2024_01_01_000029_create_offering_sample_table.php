<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offering_sample', function (Blueprint $table) {
            $table->id();
            $table->string('id_offerings')->nullable();
            $table->unsignedBigInteger('offering_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('sample_user_id')->nullable();
            $table->char('flag_sample', 1)->nullable();
            $table->longText('sample_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offering_sample');
    }
};
