<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calendar', function (Blueprint $table) {
            $table->id('idrec');
            $table->string('calendar_name');
            $table->string('calendar_type')->default('personal');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->unsignedBigInteger('id_calendar_color');
            $table->unsignedBigInteger('add_by');
            $table->text('notes')->nullable();
            $table->text('notulens')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar');
    }
};
