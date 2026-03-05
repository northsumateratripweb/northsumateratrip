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
        Schema::create('rental_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_rental_id')->constrained('car_rentals')->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('rental_days');
            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->boolean('with_driver')->default(false);
            $table->text('notes')->nullable();
            $table->integer('total_price');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'cancelled'])->default('pending');
            $table->enum('rental_status', ['booked', 'ongoing', 'completed', 'cancelled'])->default('booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_schedules');
    }
};
