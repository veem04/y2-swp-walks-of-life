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
        Schema::create('journeys', function (Blueprint $table) {
            $table->id();
            $table->decimal("start_lat", $precision = 8, $scale = 6);
            $table->decimal("start_lng", $precision = 9, $scale = 6);
            $table->decimal("end_lat", $precision = 8, $scale = 6);
            $table->decimal("end_lng", $precision = 9, $scale = 6);
            $table->date("date");
            $table->float("distance");
            $table->float("co2_emissions");
            $table->decimal("cost", $precision = 6, $scale = 2);
            $table->foreignId("user_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journeys');
    }
};
