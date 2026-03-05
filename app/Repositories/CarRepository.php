<?php

namespace App\Repositories;

use App\Models\Vehicle;
use App\Repositories\Contracts\CarRepositoryInterface;

class CarRepository implements CarRepositoryInterface
{
    public function getAvailable()
    {
        return Vehicle::where('is_active', true)->get();
    }
}
