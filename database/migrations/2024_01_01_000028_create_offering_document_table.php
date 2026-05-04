<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offering_document', function (Blueprint $table) {
            $table->id();
            $table->string('id_offerings')->nullable();
            $table->unsignedBigInteger('offering_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('rnd_user_id')->nullable();
            $table->char('flag_rnd', 1)->nullable();
            $table->longText('imgblob_1')->nullable();
            $table->longText('imgblob_2')->nullable();
            $table->longText('document_1')->nullable();
            $table->longText('document_2')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offering_document');
    }
};
