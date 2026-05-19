<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalScheduleResource\Pages;
use App\Models\RentalSchedule;
use Filament\Forms;
use Filament\Schemas;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;

class RentalScheduleResource extends Resource
{
    protected static ?string $model = RentalSchedule::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Pesanan & Jadwal';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Jadwal Rental';
    
    protected static ?int $navigationSort = 3;

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->schema([
                Schemas\Components\Section::make('Informasi Rental')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->label('ID Pesanan (Opsional)')
                            ->relationship('order', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "#ORD-" . str_pad($record->id, 5, '0', STR_PAD_LEFT) . " ({$record->customer_name})")
                            ->searchable()
                            ->preload()
                            ->columnSpanFull()
                            ->helperText('Hubungkan jadwal ini dengan pesanan pelanggan jika ada.'),
                        Forms\Components\Select::make('car_rental_id')
                            ->label('Pilih Mobil')
                            ->relationship('carRental', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->required()
                            ->maxLength(20)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->columnSpan(2),
                    ]),
                
                Schemas\Components\Section::make('Jadwal & Durasi')
                    ->icon('heroicon-o-clock')
                    ->columns(3)
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Tanggal Mulai')
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Tanggal Selesai')
                            ->required()
                            ->native(false)
                            ->after('start_date'),
                        Forms\Components\TextInput::make('rental_days')
                            ->label('Jumlah Hari')
                            ->numeric()
                            ->required()
                            ->default(1),
                    ]),
                
                Schemas\Components\Section::make('Lokasi & Detail')
                    ->icon('heroicon-o-map-pin')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('pickup_location')
                            ->label('Lokasi Penjemputan')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('dropoff_location')
                            ->label('Lokasi Pengantaran')
                            ->maxLength(255),
                        Forms\Components\Toggle::make('with_driver')
                            ->label('Dengan Driver')
                            ->default(false),
                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                
                Schemas\Components\Section::make('Harga & Status')
                    ->icon('heroicon-o-banknotes')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('total_price')
                            ->label('Total Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Lunas',
                                'partial' => 'DP',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\Select::make('rental_status')
                            ->label('Status Rental')
                            ->options([
                                'booked' => 'Dipesan',
                                'ongoing' => 'Sedang Berjalan',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ])
                            ->default('booked')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('carRental.name')
                    ->label('Mobil')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->description(fn (RentalSchedule $record): string => $record->customer_phone),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('rental_days')
                    ->label('Hari')
                    ->suffix(' hari')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', true)
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'partial' => 'info',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Lunas',
                        'partial' => 'DP',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('rental_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'booked' => 'info',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'booked' => 'Dipesan',
                        'ongoing' => 'Berjalan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Lunas',
                        'partial' => 'DP',
                        'cancelled' => 'Dibatalkan',
                    ]),
                Tables\Filters\SelectFilter::make('rental_status')
                    ->label('Status Rental')
                    ->options([
                        'booked' => 'Dipesan',
                        'ongoing' => 'Sedang Berjalan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
                Tables\Filters\Filter::make('start_date_month')
                    ->form([
                        Forms\Components\Select::make('month')
                            ->label('Bulan')
                            ->options([
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
                            ]),
                    ])
                    ->query(function ($query, array $data) {
                        return $query->when($data['month'], fn ($query, $month) => $query->whereMonth('start_date', $month));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRentalSchedules::route('/'),
            'create' => Pages\CreateRentalSchedule::route('/create'),
            'view' => Pages\ViewRentalSchedule::route('/{record}'),
            'edit' => Pages\EditRentalSchedule::route('/{record}/edit'),
        ];
    }
}
