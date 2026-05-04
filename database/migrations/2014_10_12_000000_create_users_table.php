<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('real_email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->integer('role')->default(0);
            $table->integer('department')->nullable();
            $table->string('role_name')->nullable();
            $table->string('employee_id')->nullable();
            $table->unsignedBigInteger('company_id')->default(0);
            $table->string('sales_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('image')->default('No Image');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->char('kanban', 1)->default('1');
            $table->char('hr', 1)->default('1');
            $table->char('hr_1', 1)->default('1');
            $table->char('hr_2', 1)->default('1');
            $table->char('hr_3', 1)->default('1');
            $table->char('hr_4', 1)->default('1');
            $table->char('hr_5', 1)->default('1');
            $table->char('hr_6', 1)->default('1');
            $table->char('hr_7', 1)->default('1');
            $table->char('hr_8', 1)->default('1');
            $table->char('hr_9', 1)->default('1');
            $table->char('hr_10', 1)->default('1');
            $table->char('hr_11', 1)->default('1');
            $table->char('ga', 1)->default('1');
            $table->char('ga_1', 1)->default('1');
            $table->char('ga_2', 1)->default('1');
            $table->char('ga_3', 1)->default('1');
            $table->char('ga_4', 1)->default('1');
            $table->char('ga_5', 1)->default('1');
            $table->char('ga_6', 1)->default('1');
            $table->char('ga_7', 1)->default('1');
            $table->char('ga_8', 1)->default('1');
            $table->char('ga_9', 1)->default('1');
            $table->char('ga_10', 1)->default('1');
            $table->char('ga_11', 1)->default('1');
            $table->char('ga_12', 1)->default('1');
            $table->char('ga_13', 1)->default('1');
            $table->char('ga_14', 1)->default('1');
            $table->char('ga_15', 1)->default('1');
            $table->char('ga_16', 1)->default('1');
            $table->char('ga_17', 1)->default('1');
            $table->char('ga_18', 1)->default('1');
            $table->char('ga_19', 1)->default('1');
            $table->char('ga_20', 1)->default('1');
            $table->char('ga_21', 1)->default('1');
            $table->char('ga_22', 1)->default('1');
            $table->char('ga_23', 1)->default('1');
            $table->char('ga_24', 1)->default('1');
            $table->char('ga_25', 1)->default('1');
            $table->char('ga_26', 1)->default('1');
            $table->char('ga_27', 1)->default('1');
            $table->char('master_data', 1)->default('1');
            $table->char('md_1', 1)->default('1');
            $table->char('md_2', 1)->default('1');
            $table->char('md_3', 1)->default('1');
            $table->char('md_4', 1)->default('1');
            $table->char('md_5', 1)->default('1');
            $table->char('md_6', 1)->default('1');
            $table->char('md_7', 1)->default('1');
            $table->char('md_8', 1)->default('1');
            $table->char('md_9', 1)->default('1');
            $table->char('md_10', 1)->default('1');
            $table->char('md_11', 1)->default('1');
            $table->char('md_12', 1)->default('1');
            $table->char('md_13', 1)->default('1');
            $table->char('md_14', 1)->default('1');
            $table->char('md_15', 1)->default('1');
            $table->char('md_16', 1)->default('1');
            $table->char('md_17', 1)->default('1');
            $table->char('md_18', 1)->default('1');
            $table->char('md_19', 1)->default('1');
            $table->char('md_20', 1)->default('1');
            $table->char('md_21', 1)->default('1');
            $table->char('md_22', 1)->default('1');
            $table->char('md_23', 1)->default('1');
            $table->char('md_24', 1)->default('1');
            $table->char('md_25', 1)->default('1');
            $table->char('calendar', 1)->default('1');
            $table->char('google', 1)->default('1');
            $table->char('google_calendar', 1)->default('1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
