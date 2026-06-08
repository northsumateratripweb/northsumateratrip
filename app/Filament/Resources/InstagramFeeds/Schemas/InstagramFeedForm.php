<?php

namespace App\Filament\Resources\InstagramFeeds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InstagramFeedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('post_id')
                    ->maxLength(255),
                FileUpload::make('image_url')
                    ->image()
                    ->disk('public')
                    ->directory('instagram')
                    ->visibility('public')
                    ->required(),
                Textarea::make('caption')
                    ->rows(3),
                TextInput::make('permalink')
                    ->url()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
