<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_child_company', function (Blueprint $table) {
            $table->unsignedBigInteger('id_company')->primary();
            $table->string('name');
            $table->string('company_type')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_child_company');
    }
};
