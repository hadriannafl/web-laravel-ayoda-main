<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visiting_report_follow_up', function (Blueprint $table) {
            $table->id();
            $table->string('id_report')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('stage')->nullable();
            $table->text('notulens')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visiting_report_follow_up');
    }
};
