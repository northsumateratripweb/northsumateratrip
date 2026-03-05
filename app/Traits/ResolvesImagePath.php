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
    public static function resolveImagePath(?string $path, string $fallbackDir = 'images', string $placeholder = ''): string
    {
        if (!$path) {
            return $placeholder ?: 'https://placehold.co/800x600/3B82F6/white?text=No+Image';
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        // Uploaded via Filament (path contains directory prefix like "products/file.jpg")
        $storagePath = public_path('storage/' . $path);
        if (file_exists($storagePath)) {
            return asset('storage/' . $path);
        }

        // Legacy/demo: bare filename in public/{fallbackDir}/
        $publicPath = public_path($fallbackDir . '/' . $path);
        if (file_exists($publicPath)) {
            return asset($fallbackDir . '/' . $path);
        }

        // Try storage path without directory check (for paths like "products/abc.jpg")
        if (str_contains($path, '/')) {
            return asset('storage/' . $path);
        }

        // File not found anywhere — return placeholder
        return $placeholder ?: 'https://placehold.co/800x600/3B82F6/white?text=' . urlencode(basename($path));
    }
}
