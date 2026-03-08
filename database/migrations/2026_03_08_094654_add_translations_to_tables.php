<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = ['products', 'car_rentals', 'rental_packages', 'categories', 'blogs'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                if (!Schema::hasColumn($table, 'translations')) {
                    $blueprint->json('translations')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        $tables = ['products', 'car_rentals', 'rental_packages', 'categories', 'blogs'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                if (Schema::hasColumn($table, 'translations')) {
                    $blueprint->dropColumn('translations');
                }
            });
        }
    }
};
