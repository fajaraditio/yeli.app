<?php

use App\Constants\UnitLearningMaterialConstant;
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
        Schema::create('submission_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title')->nullable();
            $table->string('file_path')->nullable();
            $table->string('type')->default(UnitLearningMaterialConstant::Type_Pdf);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_materials');
    }
};
