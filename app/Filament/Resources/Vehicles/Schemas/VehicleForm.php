<?php

namespace App\Filament\Resources\Vehicles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VehicleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('plate_number')
                    ->unique(ignoreRecord: true)
                    ->required()
                    ->maxLength(20),
                TextInput::make('capacity')
                    ->numeric()
                    ->minValue(1),
                Select::make('type')
                    ->options([
                        'SUV' => 'SUV',
                        'MPV' => 'MPV',
                        'Van' => 'Van',
                        'Bus' => 'Bus',
                        'Sedan' => 'Sedan',
                    ])
                    ->required(),
                TextInput::make('brand')
                    ->label('Merek')
                    ->maxLength(100),
                TextInput::make('transmission')
                    ->label('Transmisi')
                    ->maxLength(50)
                    ->placeholder('Manual / Automatic'),
                FileUpload::make('thumbnail')
                    ->label('Foto Kendaraan')
                    ->disk('public')
                    ->directory('vehicles')
                    ->visibility('public')
                    ->image(),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
