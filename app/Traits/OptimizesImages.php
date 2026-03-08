<?php

namespace App\Traits;

use App\Helpers\ImageProcessor;
use Illuminate\Support\Facades\Log;

trait OptimizesImages
{
    /**
     * Boot the trait and register the saving observer.
     */
    public static function bootOptimizesImages()
    {
        static::saving(function ($model) {
            // Get fields to optimize from model property or use defaults
            $fields = property_exists($model, 'optimizableImages') 
                ? $model->optimizableImages 
                : ['featured_image', 'gallery_images'];
            
            foreach ($fields as $field) {
                // Only process if the field has changed
                if ($model->isDirty($field)) {
                    $value = $model->getAttribute($field);
                    
                    if (empty($value)) {
                        continue;
                    }

                    try {
                        if (is_array($value)) {
                            $processedImages = [];
                            foreach ($value as $imagePath) {
                                if (is_string($imagePath)) {
                                    $processedImages[] = ImageProcessor::toWebp($imagePath);
                                } else {
                                    $processedImages[] = $imagePath;
                                }
                            }
                            // Use setAttribute to trigger Laravel's array casting correctly
                            $model->setAttribute($field, $processedImages);
                        } elseif (is_string($value)) {
                            $model->setAttribute($field, ImageProcessor::toWebp($value));
                        }
                    } catch (\Exception $e) {
                        Log::error("Failed to optimize image field [{$field}] for model [" . get_class($model) . "]: " . $e->getMessage());
                    }
                }
            }
        });
    }
}
