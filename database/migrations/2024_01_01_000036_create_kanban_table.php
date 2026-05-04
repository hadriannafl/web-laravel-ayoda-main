<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kanban', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('KanBanBoard_ID')->nullable();
            $table->string('ToDo')->nullable();
            $table->string('ToDoType')->nullable();
            $table->text('ToDoDescription')->nullable();
            $table->longText('ToDoPhoto')->nullable();
            $table->string('ToDoPhoto_name')->nullable();
            $table->date('ToDoDate')->nullable();
            $table->date('ToDoDue')->nullable();
            $table->string('status')->default('todo');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->date('created_date')->nullable();
            $table->date('lastupdate')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanban');
    }
};
