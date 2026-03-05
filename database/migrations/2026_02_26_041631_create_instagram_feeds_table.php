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
        Schema::create('instagram_feeds', function (Blueprint $table) {
            $table->id();
            $table->string('post_id')->nullable()->index();
            $table->string('image_url');
            $table->text('caption')->nullable();
            $table->string('permalink')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instagram_feeds');
    }
};
