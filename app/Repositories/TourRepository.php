<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Contracts\TourRepositoryInterface;

class TourRepository implements TourRepositoryInterface
{
    protected $query;

    public function __construct()
    {
        $this->query = Product::query();
    }

    public function all()
    {
        return $this->query->get();
    }

    public function with(array $relations)
    {
        $this->query = $this->query->with($relations);
        return $this;
    }

    public function findBySlug($slug)
    {
        return $this->query->where('slug', $slug)->firstOrFail();
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }
}
