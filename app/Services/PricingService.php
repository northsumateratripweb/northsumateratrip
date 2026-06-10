<?php

namespace App\Services;

use App\Models\CarRental;
use App\Models\Product;
use App\Models\RentalPackage;

class PricingService
{
    /**
     * Calculate total price for a tour product based on number of adults and children.
     */
    public static function calculateTourPrice(Product $product, int $paxAdult, int $paxChild): float
    {
        $pricings = $product->pricings()->orderBy('pax', 'asc')->get();
        $pricePerAdult = $product->price_min ?? 0;
        $childPrice = $product->child_price ?? 0;

        if ($pricings->isNotEmpty()) {
            // Find exact match
            $matched = $pricings->firstWhere('pax', $paxAdult);

            if ($matched) {
                $pricePerAdult = (float) $matched->price_per_person;
            } else {
                // Find nearest lower bracket
                $lowerMatched = $pricings->filter(fn($r) => (int) $r->pax <= $paxAdult)->last();
                if ($lowerMatched) {
                    $pricePerAdult = (float) $lowerMatched->price_per_person;
                } else {
                    // Fallback to the lowest available bracket if fewer than minimum pax
                    $lowestMatched = $pricings->first();
                    if ($lowestMatched) {
                        $pricePerAdult = (float) $lowestMatched->price_per_person;
                    }
                }
            }
        }

        return ($pricePerAdult * $paxAdult) + ($childPrice * $paxChild);
    }

    /**
     * Calculate total price for a car rental based on number of days.
     */
    public static function calculateCarRentalPrice(CarRental $carRental, int $days): float
    {
        $pricePerDay = (float) ($carRental->price_per_day ?? 0);
        $pricings = $carRental->pricings()->orderBy('days', 'asc')->get();

        if ($pricings->isNotEmpty()) {
            // Find exact match or nearest lower bracket
            $matched = $pricings->filter(fn($r) => (int) $r->days <= $days)->last();
            if ($matched) {
                $pricePerDay = (float) $matched->price;
            }
        }

        return $pricePerDay * $days;
    }

    /**
     * Calculate total price for a rental package based on number of days.
     */
    public static function calculateRentalPackagePrice(RentalPackage $package, int $days): float
    {
        return $package->price_per_day * $days;
    }
}
