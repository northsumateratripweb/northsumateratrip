<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ImageProcessor
{
    /**
     * Process an image: Resize and convert to WebP.
     *
     * @param string $path The relative path within the disk.
     * @param string $disk The storage disk name.
     * @param int $maxWidth The maximum width for scaling.
     * @return string The new path (with updated extension).
     */
    public static function toWebp(string $path, string $disk = 'public', int $maxWidth = 1200): string
    {
        if (!Storage::disk($disk)->exists($path)) {
            return $path;
        }

        $fullPath = Storage::disk($disk)->path($path);
        
        // Skip if already webp
        if (Str::lower(pathinfo($fullPath, PATHINFO_EXTENSION)) === 'webp') {
            return $path;
        }

        try {
            $imageData = Image::read($fullPath);
            
            // Resize if needed
            if ($imageData->width() > $maxWidth) {
                $imageData->scale(width: $maxWidth);
            }

            // Encode to WebP
            $webpEncoded = $imageData->toWebp(quality: 80);
            
            // Generate new path
            $newPath = Str::beforeLast($path, '.') . '.webp';
            
            // Save webp
            Storage::disk($disk)->put($newPath, (string)$webpEncoded);
            
            // Delete original file if the filename/extension changed
            if ($newPath !== $path) {
                Storage::disk($disk)->delete($path);
            }

            return $newPath;
        } catch (\Exception $e) {
            \Log::error('Image optimization failed: ' . $e->getMessage(), [
                'path' => $path,
                'disk' => $disk
            ]);
            return $path; // Return original path if it fails
        }
    }
}
