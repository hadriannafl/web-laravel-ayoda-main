<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('task_history', function (Blueprint $table) {
            $table->id('idrec');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->tinyInteger('project_status_id')->nullable();
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('success_rate', 5, 2)->default(0);
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_history');
    }
};
