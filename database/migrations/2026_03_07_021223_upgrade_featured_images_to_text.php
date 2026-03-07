<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('featured_image')->change();
        });
        
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->text('featured_image')->change();
        });

        if (Schema::hasTable('rental_packages')) {
            Schema::table('rental_packages', function (Blueprint $table) {
                $table->text('featured_image')->change();
            });
        }

        if (Schema::hasTable('blogs')) {
            Schema::table('blogs', function (Blueprint $table) {
                $table->text('featured_image')->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('featured_image')->change();
        });
        
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->string('featured_image')->change();
        });
    }
};
