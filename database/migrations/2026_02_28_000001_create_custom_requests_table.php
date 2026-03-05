<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_requests', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            $table->date('trip_date')->nullable();
            $table->unsignedTinyInteger('trip_duration')->default(1)->comment('days');
            $table->unsignedSmallInteger('num_persons')->default(1);
            $table->string('destinations')->nullable()->comment('Preferred destinations/interests');
            $table->string('budget_range')->nullable()->comment('e.g. 1jt-2jt');
            $table->string('accommodation_type')->nullable();
            $table->string('transport_type')->nullable();
            $table->text('special_requests')->nullable();
            $table->enum('status', ['new', 'reviewed', 'responded', 'closed'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_requests');
    }
};
