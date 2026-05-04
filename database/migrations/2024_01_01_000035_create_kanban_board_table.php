<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kanban_board', function (Blueprint $table) {
            $table->id();
            $table->string('BoardName');
            $table->unsignedBigInteger('add_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kanban_board');
    }
};
