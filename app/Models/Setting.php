<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = \Illuminate\Support\Facades\Cache::remember('site_settings', 3600, function() {
            return static::all()->pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;
        
        // Handle JSON strings (for arrays/objects)
        if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
            try {
                return json_decode($value, true) ?: $value;
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $value;
    }

    public static function set(string $key, mixed $value): void
    {
        $finalValue = is_array($value) ? json_encode($value) : $value;
        static::query()->updateOrCreate(['key' => $key], ['value' => $finalValue]);
        
        // Clear semua cache terkait settings
        \Illuminate\Support\Facades\Cache::forget('site_settings');
        \Illuminate\Support\Facades\Cache::forget('app_settings');
        \Illuminate\Support\Facades\Cache::forget('nav_categories');
    }
}
