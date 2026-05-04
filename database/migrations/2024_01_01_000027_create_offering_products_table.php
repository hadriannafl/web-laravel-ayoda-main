<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offering_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offering_id');
            $table->string('id_offerings')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 15, 2)->default(0);
            $table->string('m_currency')->nullable();
            $table->decimal('moqty', 15, 2)->default(0);
            $table->decimal('qty', 15, 2)->default(0);
            $table->decimal('sample_qty', 15, 2)->default(0);
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('rnd_user_id')->nullable();
            $table->char('rnd_flag', 1)->nullable();
            $table->dateTime('document_date')->nullable();
            $table->unsignedBigInteger('document_sent_by')->nullable();
            $table->unsignedBigInteger('sample_user_id')->nullable();
            $table->char('flag_sample', 1)->nullable();
            $table->dateTime('sample_delivery_date')->nullable();
            $table->string('sample_delivery_reff')->nullable();
            $table->string('img_1')->nullable();
            $table->string('img_2')->nullable();
            $table->char('show_product', 1)->default('Y');
            $table->text('notes_document')->nullable();
            $table->text('notes_sample')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offering_products');
    }
};
