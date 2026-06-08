<?php

namespace App\Models;

use App\Helpers\ImageProcessor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('site_settings', 3600, function () {
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
        // Optimize images for specific keys
        $imageKeys = ['site_logo', 'site_favicon', 'default_hero_image', 'qris_image'];

        if (in_array($key, $imageKeys) && ! empty($value)) {
            try {
                if (is_array($value)) {
                    $processed = [];
                    foreach ($value as $path) {
                        $newPath = ImageProcessor::toWebp($path, 'public');
                        $processed[] = $newPath;
                    }
                    $value = $processed;
                } elseif (is_string($value)) {
                    $value = ImageProcessor::toWebp($value, 'public');
                }
            } catch (\Exception $e) {
                // Silently fail optimization during bootstrap if needed
            }
        }

        $finalValue = is_array($value) ? json_encode($value) : $value;
        static::query()->updateOrCreate(['key' => $key], ['value' => $finalValue]);

        // Clear semua cache terkait settings
        Cache::forget('site_settings');
        Cache::forget('app_settings');
        Cache::forget('nav_categories');
    }
}
