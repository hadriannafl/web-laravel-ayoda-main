<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incident_report_follow_up', function (Blueprint $table) {
            $table->id();
            $table->string('id_report')->nullable();
            $table->longText('file')->nullable();
            $table->longText('image')->nullable();
            $table->text('notes')->nullable();
            $table->string('add_by')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_report_follow_up');
    }
};
