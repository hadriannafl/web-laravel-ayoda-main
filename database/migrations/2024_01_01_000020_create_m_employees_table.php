<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_employees', function (Blueprint $table) {
            $table->id('idemployee');
            $table->string('nik')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('DoB')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('marital_status')->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('religion')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('poh')->nullable();
            $table->unsignedBigInteger('id_company')->nullable();
            $table->string('employee_type')->nullable();
            $table->date('joined_date')->nullable();
            $table->string('department')->nullable();
            $table->string('title_structural')->nullable();
            $table->string('position')->nullable();
            $table->string('npwp_num')->nullable();
            $table->string('npwp_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_acc_num')->nullable();
            $table->string('bank_acc_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('ACTIVE');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_employees');
    }
};
