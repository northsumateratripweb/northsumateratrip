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
        Schema::create('product_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->integer('pax');
            $table->decimal('price_per_person', 15, 2);
            $table->timestamps();
        });

        // Migrate data
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            if (!empty($product->pricing_details)) {
                $pricings = json_decode($product->pricing_details, true);
                if (is_array($pricings)) {
                    foreach ($pricings as $pricing) {
                        if (isset($pricing['pax']) && isset($pricing['price_per_person'])) {
                            DB::table('product_pricings')->insert([
                                'product_id' => $product->id,
                                'pax' => $pricing['pax'],
                                'price_per_person' => $pricing['price_per_person'],
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
            $table->dropColumn('pricing_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('pricing_details')->nullable();
        });

        // Revert data
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $pricings = DB::table('product_pricings')->where('product_id', $product->id)->get();
            if ($pricings->count() > 0) {
                $json = [];
                foreach ($pricings as $pricing) {
                    $json[] = [
                        'pax' => $pricing->pax,
                        'price_per_person' => $pricing->price_per_person,
                    ];
                }
                DB::table('products')->where('id', $product->id)->update([
                    'pricing_details' => json_encode($json),
                ]);
            }
        }

        Schema::dropIfExists('product_pricings');
    }
};
