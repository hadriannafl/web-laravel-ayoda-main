<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->string('id_offerings')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('pic')->nullable();
            $table->unsignedBigInteger('id_offering_color')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->text('notes')->nullable();
            $table->text('notulens')->nullable();
            $table->char('offerings_flag', 1)->default('Y');
            $table->char('project_flag', 1)->default('N');
            $table->string('sample_flag')->default('No');
            $table->unsignedBigInteger('add_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offerings');
    }
};
