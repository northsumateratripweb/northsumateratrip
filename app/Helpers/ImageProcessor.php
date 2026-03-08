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
        // Check if file exists on specified disk, otherwise try 'local' or 'public' as fallback
        if (!Storage::disk($disk)->exists($path)) {
            $fallbackDisk = ($disk === 'public') ? 'local' : 'public';
            if (Storage::disk($fallbackDisk)->exists($path)) {
                $disk = $fallbackDisk;
            } else {
                return $path;
            }
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

            // Encode to WebP explicitly as string to avoid corruption
            $encoded = $imageData->toWebp(quality: 80);
            $binaryData = (string) $encoded;
            
            $encodedSize = strlen($binaryData);
            
            // Check if encoding resulted in valid data (avoiding the 6KB empty/header-only issue)
            if ($encodedSize < 100) {
                 throw new \Exception("Encoded image data is suspiciously small ({$encodedSize} bytes)");
            }

            // Generate new path with .webp extension
            $newPath = Str::beforeLast($path, '.') . '.webp';
            
            // Save webp
            Storage::disk($disk)->put($newPath, $binaryData);
            
            // Delete original file if the filename/extension changed
            if ($newPath !== $path) {
                Storage::disk($disk)->delete($path);
            }

            return $newPath;
        } catch (\Exception $e) {
            return $path;
        }
    }
}
