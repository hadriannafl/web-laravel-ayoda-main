<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kanban_notes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('notes')->nullable();
            $table->longText('image')->nullable();
            $table->string('image_name')->nullable();
            $table->unsignedBigInteger('add_by')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanban_notes');
    }
};
