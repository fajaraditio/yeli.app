<?php

use App\Constants\TaskConstant;
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
        Schema::create('unit_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_stage_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('indicator')->nullable(); // Interpretation, Analysis, etc.
            $table->longText('instructions')->nullable();
            $table->longText('excerpt')->nullable();
            $table->json('input_schema')->nullable(); // defines the form fields rendered to the student
            $table->string('status')->default(TaskConstant::Status_Published);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_tasks');
    }
};
