<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventory_assets_request_detail', function (Blueprint $table) {
            $table->id();
            $table->string('idreqform')->nullable();
            $table->string('idassets')->nullable();
            $table->string('idsupplier')->nullable();
            $table->string('id_rab')->nullable();
            $table->decimal('balance_rab', 20, 2)->default(0);
            $table->decimal('qty', 15, 2)->default(0);
            $table->string('unit')->nullable();
            $table->decimal('price', 20, 2)->default(0);
            $table->decimal('total', 20, 2)->default(0);
            $table->decimal('balance', 20, 2)->default(0);
            $table->string('status')->nullable();
            $table->string('approval1stat')->nullable();
            $table->string('approval2stat')->nullable();
            $table->string('approvalstat')->nullable();
            $table->string('aktifyn')->nullable();
            $table->text('remarks')->nullable();
            $table->text('message')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_assets_request_detail');
    }
};
