<?php

namespace App\Filament\Resources\TripSchedules\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TripScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id') // Usually customized to show customer name
                    ->getOptionLabelFromRecordUsing(fn ($record) => "#{$record->id} - {$record->customer_name}")
                    ->searchable()
                    ->required(),
                Select::make('vehicle_id')
                    ->relationship('vehicle', 'name')
                    ->searchable()
                    ->preload(),
                TextInput::make('driver_name')
                    ->maxLength(255),
                TextInput::make('driver_phone')
                    ->tel()
                    ->maxLength(20),
                DatePicker::make('trip_date')
                    ->required(),
                Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'ongoing' => 'Ongoing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->default('scheduled'),
                Textarea::make('notes')
                    ->rows(3),
            ]);
    }
}
