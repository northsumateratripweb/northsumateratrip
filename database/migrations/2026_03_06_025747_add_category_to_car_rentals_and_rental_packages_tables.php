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
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
        });

        Schema::table('rental_packages', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->dropColumn('category');
        });

        Schema::table('rental_packages', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
