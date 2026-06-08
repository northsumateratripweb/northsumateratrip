<?php

namespace App\Filament\Resources\PromotionBanners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromotionBannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('image_url')
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->visibility('public')
                    ->required(),
                TextInput::make('link_url')
                    ->maxLength(255),
                Select::make('position')
                    ->options([
                        'home_top' => 'Home Top',
                        'home_middle' => 'Home Middle',
                        'sidebar' => 'Sidebar',
                    ]),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
