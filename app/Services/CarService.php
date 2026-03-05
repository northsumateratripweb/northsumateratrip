<?php

namespace App\Services;

use App\Repositories\Contracts\CarRepositoryInterface;

class CarService
{
    protected $carRepository;

    public function __construct(CarRepositoryInterface $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function getAvailableCars()
    {
        return $this->carRepository->getAvailable();
    }
}
