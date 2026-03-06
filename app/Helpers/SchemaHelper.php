<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class SchemaHelper
{
    public static function product($product)
    {
        $schema = [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'image' => $product->image_url,
            'description' => $product->short_description ?? Str::limit(strip_tags($product->description), 160),
            'sku' => 'PKG-' . $product->id,
            'brand' => [
                '@type' => 'Brand',
                'name' => config('app.name', 'NorthSumateraTrip')
            ],
            'offers' => [
                '@type' => 'AggregateOffer',
                'priceCurrency' => 'IDR',
                'lowPrice' => $product->price_min,
                'highPrice' => $product->price_max,
                'offerCount' => 1,
                'availability' => 'https://schema.org/InStock'
            ]
        ];

        if ($product->review_count > 0) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $product->rating ?? 5,
                'reviewCount' => $product->review_count
            ];
        }

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    public static function breadcrumbs($links)
    {
        $items = [];
        $i = 1;
        foreach ($links as $name => $url) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $i++,
                'name' => $name,
                'item' => $url
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }

    public static function organization($settings)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency',
            'name' => $settings['site_name'] ?? 'NorthSumateraTrip',
            'url' => url('/'),
            'logo' => asset('storage/' . ($settings['site_logo'] ?? '')),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => $settings['whatsapp_number'] ?? '',
                'contactType' => 'customer service'
            ],
            'sameAs' => array_filter([
                $settings['facebook_url'] ?? null,
                $settings['instagram_url'] ?? null,
                $settings['youtube_url'] ?? null
            ])
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
    }
    public static function car($car)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Car',
            'name' => $car->name,
            'image' => $car->image_url,
            'description' => strip_tags($car->description),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'NorthSumateraTrip'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => url()->current(),
                'priceCurrency' => \App\Services\CurrencyService::code(),
                'price' => currency($car->price_per_day, null, false),
                'availability' => 'https://schema.org/InStock'
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    public static function rentalPackage($package)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $package->name,
            'image' => $package->image_url,
            'description' => strip_tags($package->description),
            'brand' => [
                '@type' => 'Brand',
                'name' => 'NorthSumateraTrip'
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => url()->current(),
                'priceCurrency' => \App\Services\CurrencyService::code(),
                'price' => currency($package->price_per_day, null, false),
                'availability' => 'https://schema.org/InStock'
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>';
    }
}
