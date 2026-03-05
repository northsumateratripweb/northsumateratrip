<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('trip_type')->nullable()->after('notes');
            $table->date('trip_end_date')->nullable()->after('trip_date');
            $table->string('customer_whatsapp')->nullable()->after('customer_phone');
            $table->string('hotel_1')->nullable()->after('trip_type');
            $table->string('hotel_2')->nullable()->after('hotel_1');
            $table->string('hotel_3')->nullable()->after('hotel_2');
            $table->string('hotel_4')->nullable()->after('hotel_3');
            $table->text('flight_info')->nullable()->after('hotel_4');
            $table->boolean('use_drone')->default(false)->after('flight_info');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'trip_type', 'trip_end_date', 'customer_whatsapp',
                'hotel_1', 'hotel_2', 'hotel_3', 'hotel_4',
                'flight_info', 'use_drone',
            ]);
        });
    }
};
