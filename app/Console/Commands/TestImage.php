<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class TestImage extends Command
{
    protected $signature = 'app:test-image';

    protected $description = 'Command description';

    public function handle()
    {
        $products = Product::all();
        foreach ($products as $p) {
            $this->info($p->name . ' -> ' . $p->featured_image);
        }
    }
}
