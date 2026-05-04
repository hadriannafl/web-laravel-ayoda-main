<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('calendar_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_calendar');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calendar_users');
    }
};
