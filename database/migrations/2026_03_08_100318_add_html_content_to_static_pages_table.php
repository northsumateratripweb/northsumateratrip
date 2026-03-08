<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            $table->string('content_type')->default('text')->after('slug');
            $table->longText('html_content')->nullable()->after('content');
            $table->text('content')->nullable()->change(); // Make existing content nullable
        });
    }

    public function down(): void
    {
        Schema::table('static_pages', function (Blueprint $table) {
            $table->dropColumn(['content_type', 'html_content']);
        });
    }
};
