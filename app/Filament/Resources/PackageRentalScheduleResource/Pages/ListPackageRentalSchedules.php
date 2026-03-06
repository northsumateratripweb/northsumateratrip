<?php

namespace App\Filament\Resources\PackageRentalScheduleResource\Pages;

use App\Filament\Resources\PackageRentalScheduleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPackageRentalSchedules extends ListRecords
{
    protected static string $resource = PackageRentalScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
