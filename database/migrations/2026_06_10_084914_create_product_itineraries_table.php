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
        Schema::create('product_itineraries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('day');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Migrate data
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            if (!empty($product->itinerary)) {
                $itineraries = json_decode($product->itinerary, true);
                if (is_array($itineraries)) {
                    foreach ($itineraries as $itinerary) {
                        if (isset($itinerary['day']) && isset($itinerary['title'])) {
                            DB::table('product_itineraries')->insert([
                                'product_id' => $product->id,
                                'day' => $itinerary['day'],
                                'title' => $itinerary['title'],
                                'description' => $itinerary['description'] ?? null,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }

        // Drop column
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('itinerary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('itinerary')->nullable();
        });

        // Revert data
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $itineraries = DB::table('product_itineraries')->where('product_id', $product->id)->get();
            if ($itineraries->count() > 0) {
                $json = [];
                foreach ($itineraries as $itinerary) {
                    $json[] = [
                        'day' => $itinerary->day,
                        'title' => $itinerary->title,
                        'description' => $itinerary->description,
                    ];
                }
                DB::table('products')->where('id', $product->id)->update([
                    'itinerary' => json_encode($json),
                ]);
            }
        }

        Schema::dropIfExists('product_itineraries');
    }
};
