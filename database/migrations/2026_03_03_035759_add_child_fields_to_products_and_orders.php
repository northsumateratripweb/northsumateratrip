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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('child_price', 15, 2)->default(0)->after('price_min');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('pax_adult')->default(1)->after('trip_type');
            $table->integer('pax_child')->default(0)->after('pax_adult');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('child_price');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['pax_adult', 'pax_child']);
        });
    }
};
