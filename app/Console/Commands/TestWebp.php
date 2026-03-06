<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\ImageProcessor;

class TestWebp extends Command
{
    protected $signature = 'app:test-webp';
    protected $description = 'Test Image Processor';

    public function handle()
    {
        $path = 'products/01KJZEYRXCMB7G1FAW29WJM3CR.jpg';
        $this->info("Checking WebP conversion for: " . $path);
        
        try {
            $newPath = ImageProcessor::toWebp($path, 'public');
            $this->info("Result: " . $newPath);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
