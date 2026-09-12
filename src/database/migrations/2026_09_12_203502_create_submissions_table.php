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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('lecturer_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('classroom_id')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained()->noActionOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('bloom_id')->nullable();
            $table->string('student_code')->nullable();
            $table->string('lecturer_code')->nullable();
            $table->string('classroom_name')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('bloom_name')->nullable();
            $table->string('bloom_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
