<?php

namespace App\Traits;

trait ResolvesImagePath
{
    /**
     * Resolve an image path to a full URL.
     *
     * Handles:
     * - null/empty → placeholder
     * - Full URL (http/https) → returned as-is
     * - Path with slash (e.g. products/file.jpg) → stored via Filament → storage/
     * - Bare filename (e.g. file.jpg) → legacy demo image → {fallbackDir}/
     */
    public static function resolveImagePath(string|array|null $path, string $fallbackDir = 'images', string $placeholder = ''): string
    {
        // Handle JSON string (Filament multiple saves as JSON array in a string if not cast)
        if (is_string($path) && (str_starts_with($path, '[') || str_starts_with($path, '{'))) {
            try {
                $decoded = json_decode($path, true);
                if (is_array($decoded)) {
                    $path = $decoded;
                }
            } catch (\Exception $e) {}
        }

        // Handle array (multiple uploads) — take first image as main
        if (is_array($path)) {
            $path = !empty($path) ? $path[0] : null;
        }

        // Handle empty or literal '[]' (common in malformed JSON data)
        if (!$path || $path === '[]') {
            return $placeholder ?: 'https://placehold.co/800x600/3B82F6/white?text=No+Image';
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // List of possible extensions to check if the exact path fails
        $extensions = ['webp', 'jpg', 'jpeg', 'png', 'HEIC'];
        $pathWithoutExt = pathinfo($path, PATHINFO_DIRNAME) . '/' . pathinfo($path, PATHINFO_FILENAME);
        if (str_starts_with($pathWithoutExt, './')) {
            $pathWithoutExt = substr($pathWithoutExt, 2);
        }

        // Try exact path in storage
        if (file_exists(public_path('storage/' . $path))) {
            return asset('storage/' . $path);
        }

        // Try alternative extensions in storage
        foreach ($extensions as $ext) {
            $candidate = $pathWithoutExt . '.' . $ext;
            if (file_exists(public_path('storage/' . $candidate))) {
                return asset('storage/' . $candidate);
            }
        }

        // Try exact path in public/{fallbackDir}
        if (file_exists(public_path($fallbackDir . '/' . $path))) {
            return asset($fallbackDir . '/' . $path);
        }

        // Try alternative extensions in public/{fallbackDir}
        foreach ($extensions as $ext) {
            $candidate = $pathWithoutExt . '.' . $ext;
            if (file_exists(public_path($fallbackDir . '/' . $candidate))) {
                return asset($fallbackDir . '/' . $candidate);
            }
        }

        // Check if path with slash exists in storage
        if (str_contains($path, '/')) {
            if (file_exists(storage_path('app/public/' . $path))) {
                return asset('storage/' . $path);
            }
        }

        // File not found anywhere — return placeholder with the filename for debugging
        return $placeholder ?: 'https://placehold.co/800x600/3B82F6/white?text=' . urlencode(basename($path));
    }
}
