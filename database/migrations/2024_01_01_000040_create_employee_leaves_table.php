<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->string('category')->nullable();
            $table->date('periode_from')->nullable();
            $table->date('periode_to')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Pending');
            $table->integer('leave_days')->default(0);
            $table->string('approval1_name')->nullable();
            $table->string('approval1_status')->nullable();
            $table->string('approval2_name')->nullable();
            $table->string('approval2_status')->nullable();
            $table->text('approval1_notes')->nullable();
            $table->text('approval2_notes')->nullable();
            $table->string('file_name')->nullable();
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_leaves');
    }
};
