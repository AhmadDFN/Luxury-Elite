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
        Schema::create('player_vehicle_specializations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_profile_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('vehicle_specialization_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_vehicle_specializations');
    }
};
