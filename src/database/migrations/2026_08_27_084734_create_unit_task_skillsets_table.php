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
        Schema::create('unit_task_skillsets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->nullable()->constrained()->noActionOnDelete()->cascadeOnUpdate();
            $table->foreignId('task_skillset_id')->nullable()->constrained()->noActionOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('order_number')->default(0);
            $table->string('excerpt');
            $table->json('question');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_task_skillsets');
    }
};
