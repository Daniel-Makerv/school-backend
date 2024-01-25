<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_task_qualification', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->unsignedBigInteger('task_id')->constrained();
            $table->integer('qualification');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_task_qualification');
    }
};