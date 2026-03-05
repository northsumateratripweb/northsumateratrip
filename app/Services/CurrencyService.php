<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\App;

class CurrencyService
{
    /**
     * Currency config per locale
     * [code, symbol, decimal_digits, position]
     */
    private static array $currencies = [
        'id' => ['code' => 'IDR', 'symbol' => 'Rp',   'decimals' => 0, 'prefix' => true],
        'ms' => ['code' => 'MYR', 'symbol' => 'RM',   'decimals' => 2, 'prefix' => true],
        'en' => ['code' => 'SGD', 'symbol' => 'S$',   'decimals' => 2, 'prefix' => true],
    ];

    /**
     * Get current currency config based on app locale
     */
    public static function current(): array
    {
        $locale = App::getLocale();
        return self::$currencies[$locale] ?? self::$currencies['id'];
    }

    /**
     * Get exchange rate from IDR to target currency
     * Rates stored in settings as: exchange_rate_myr, exchange_rate_sgd
     */
    public static function rate(string $locale = null): float
    {
        $locale = $locale ?? App::getLocale();

        return match ($locale) {
            'ms' => (float) Setting::get('exchange_rate_myr', 0.00029),  // 1 IDR → MYR
            'en' => (float) Setting::get('exchange_rate_sgd', 0.000085), // 1 IDR → SGD
            default => 1.0,
        };
    }

    /**
     * Convert an IDR amount to the current currency
     */
    public static function convert(float|int $amountIdr, string $locale = null): float
    {
        return $amountIdr * self::rate($locale);
    }

    /**
     * Format price in current currency
     */
    public static function format(float|int $amountIdr, string $locale = null): string
    {
        $locale  = $locale ?? App::getLocale();
        $config  = self::$currencies[$locale] ?? self::$currencies['id'];
        $amount  = $amountIdr * self::rate($locale);

        if ($locale === 'id') {
            // Indonesian style: Rp 1.500.000
            return $config['symbol'] . ' ' . number_format($amount, $config['decimals'], ',', '.');
        } else {
            // International style: RM 420.00 / S$ 123.50
            return $config['symbol'] . number_format($amount, $config['decimals'], '.', ',');
        }
    }

    /**
     * Get all available currencies with their info
     */
    public static function all(): array
    {
        return self::$currencies;
    }

    /**
     * Get currency symbol for current locale
     */
    public static function symbol(string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return self::$currencies[$locale]['symbol'] ?? 'Rp';
    }

    /**
     * Get currency code for current locale
     */
    public static function code(string $locale = null): string
    {
        $locale = $locale ?? App::getLocale();
        return self::$currencies[$locale]['code'] ?? 'IDR';
    }
}
