<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\CarRental;
use App\Models\Blog;
use App\Models\Hotel;
use App\Models\Vehicle;
use App\Models\Partner;
use App\Models\Review;
use App\Helpers\ImageProcessor;

class OptimizeExistingImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize existing images to WebP and compress them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Memulai optimasi gambar...");

        $models = [
            Product::class => ['featured_image', 'gallery_images'],
            CarRental::class => ['featured_image', 'gallery_images'],
            Blog::class => ['featured_image', 'gallery_images'],
            Hotel::class => ['featured_image'],
            Vehicle::class => ['thumbnail'],
            Partner::class => ['logo'],
            Review::class => ['gallery_images', 'avatar'],
        ];

        $totalOptimized = 0;

        foreach ($models as $modelClass => $fields) {
            $this->info("Memproses model: {$modelClass}");
            $records = $modelClass::all();

            foreach ($records as $record) {
                $hasUpdates = false;

                foreach ($fields as $field) {
                    $value = $record->getAttribute($field);

                    if (empty($value)) continue;

                    if (is_array($value)) {
                        $processedImages = [];
                        foreach ($value as $imagePath) {
                            if (is_string($imagePath)) {
                                $newPath = ImageProcessor::toWebp($imagePath);
                                $processedImages[] = $newPath;
                                if ($newPath !== $imagePath) $hasUpdates = true;
                            } else {
                                $processedImages[] = $imagePath;
                            }
                        }
                        if ($hasUpdates) {
                            $record->attributes[$field] = json_encode($processedImages);
                        }
                    } elseif (is_string($value)) {
                        $newPath = ImageProcessor::toWebp($value);
                        if ($newPath !== $value) {
                            $record->setAttribute($field, $newPath);
                            $hasUpdates = true;
                        }
                    }
                }

                if ($hasUpdates) {
                    $record->saveQuietly(); // Use saveQuietly to prevent triggering events/observers again
                    $totalOptimized++;
                }
            }
        }

        $this->info("Proses selesai. Berhasil mengoptimasi {$totalOptimized} record.");
    }
}
