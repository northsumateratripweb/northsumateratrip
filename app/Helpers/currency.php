<?php

use App\Services\CurrencyService;

if (! function_exists('currency')) {
    /**
     * Format an IDR price into the current locale's currency.
     * Usage in Blade: {{ currency($product->price) }}
     */
    function currency(float|int $amountIdr, string $locale = null, bool $format = true): string|float
    {
        if (! $format) {
            return CurrencyService::convert($amountIdr, $locale);
        }
        return CurrencyService::format($amountIdr, $locale);
    }
}

if (! function_exists('currency_symbol')) {
    function currency_symbol(): string
    {
        return CurrencyService::symbol();
    }
}

if (! function_exists('currency_code')) {
    function currency_code(): string
    {
        return CurrencyService::code();
    }
}
