<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('id_report')->nullable();
            $table->string('subject')->nullable();
            $table->string('category')->nullable();
            $table->string('dept')->nullable();
            $table->string('location')->nullable();
            $table->string('division_involve')->nullable();
            $table->string('person_involve')->nullable();
            $table->text('cronology')->nullable();
            $table->string('status')->default('Pending');
            $table->string('add_by')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->char('report_flag', 1)->default('Y');
            $table->longText('file_1')->nullable();
            $table->longText('file_2')->nullable();
            $table->longText('file_3')->nullable();
            $table->string('img_1')->nullable();
            $table->string('img_2')->nullable();
            $table->string('img_3')->nullable();
            $table->longText('imgblob_1')->nullable();
            $table->longText('imgblob_2')->nullable();
            $table->longText('imgblob_3')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
