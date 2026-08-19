<?php

use App\Constants\UnitConstant;
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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order')->unique();
            $table->unsignedBigInteger('bloom_id')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default(UnitConstant::Status_Draft);
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
        Schema::dropIfExists('units');
    }
};
