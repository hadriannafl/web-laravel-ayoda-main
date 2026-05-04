<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_subdepartment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('p_id_dept')->default(0);
            $table->string('name');
            $table->string('dept_name')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_subdepartment');
    }
};
