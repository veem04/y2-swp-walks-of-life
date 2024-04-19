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
        Schema::table('methods', function (Blueprint $table) {
            $table->decimal('co2_constant', total:8, places:6)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('methods', function (Blueprint $table) {
            $table->float('co2_constant')->change();
        });
    }
};
