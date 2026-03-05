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
        Schema::create('package_rental_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_package_id')->constrained('rental_packages')->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('rental_days');
            $table->string('pickup_location')->nullable();
            $table->string('destination')->nullable();
            $table->integer('number_of_people')->default(1);
            $table->text('special_requests')->nullable();
            $table->integer('total_price');
            $table->enum('payment_status', ['pending', 'paid', 'partial', 'cancelled'])->default('pending');
            $table->enum('booking_status', ['confirmed', 'ongoing', 'completed', 'cancelled'])->default('confirmed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_rental_schedules');
    }
};
