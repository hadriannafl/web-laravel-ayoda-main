<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_list_menu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->char('kanban', 1)->default('1');
            $table->char('ga', 1)->default('1');
            for ($i = 1; $i <= 26; $i++) {
                $table->char("ga_{$i}", 1)->default('1');
            }
            $table->char('hr', 1)->default('1');
            for ($i = 1; $i <= 11; $i++) {
                $table->char("hr_{$i}", 1)->default('1');
            }
            $table->char('master_data', 1)->default('1');
            for ($i = 1; $i <= 32; $i++) {
                $table->char("md_{$i}", 1)->default('1');
            }
            $table->char('calendar', 1)->default('1');
            $table->char('company_calendar', 1)->default('1');
            $table->char('google', 1)->default('1');
            $table->char('google_calendar', 1)->default('1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_list_menu');
    }
};
