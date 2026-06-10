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
        Schema::create('car_rental_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_rental_id')->constrained('car_rentals')->cascadeOnDelete();
            $table->integer('days');
            $table->decimal('price', 15, 2);
            $table->timestamps();
        });

        // Migrate data
        $carRentals = DB::table('car_rentals')->get();
        foreach ($carRentals as $rental) {
            if (!empty($rental->pricing_details)) {
                $pricings = json_decode($rental->pricing_details, true);
                if (is_array($pricings)) {
                    foreach ($pricings as $pricing) {
                        if (isset($pricing['days']) && isset($pricing['price'])) {
                            DB::table('car_rental_pricings')->insert([
                                'car_rental_id' => $rental->id,
                                'days' => $pricing['days'],
                                'price' => $pricing['price'],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                }
            }
        }

        // Drop column
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->dropColumn('pricing_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_rentals', function (Blueprint $table) {
            $table->json('pricing_details')->nullable();
        });

        // Revert data
        $carRentals = DB::table('car_rentals')->get();
        foreach ($carRentals as $rental) {
            $pricings = DB::table('car_rental_pricings')->where('car_rental_id', $rental->id)->get();
            if ($pricings->count() > 0) {
                $json = [];
                foreach ($pricings as $pricing) {
                    $json[] = [
                        'days' => $pricing->days,
                        'price' => $pricing->price,
                    ];
                }
                DB::table('car_rentals')->where('id', $rental->id)->update([
                    'pricing_details' => json_encode($json),
                ]);
            }
        }

        Schema::dropIfExists('car_rental_pricings');
    }
};
