<?php

namespace App\Filament\Resources\TripSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class TripSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('trip_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('order.customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable(),
                \Filament\Tables\Columns\SelectColumn::make('status')
                    ->label('Status')
                    ->options([
                        'scheduled' => 'Sudah Booking',
                        'ongoing' => 'Sedang Jalan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
                \Filament\Tables\Columns\TextColumn::make('order.customer_phone')
                    ->label('Nomor HP'),
                \Filament\Tables\Columns\TextColumn::make('driver_name')
                    ->label('Driver')
                    ->placeholder('Belum ada'),
                \Filament\Tables\Columns\TextColumn::make('service_type')
                    ->label('Layanan')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->order->vehicle_id ? 'Sewa Mobil' : 'Paket Trip')
                    ->color(fn (string $state): string => match ($state) {
                        'Sewa Mobil' => 'warning',
                        'Paket Trip' => 'info',
                    }),
                \Filament\Tables\Columns\TextColumn::make('vehicle.name')
                    ->label('Jenis Mobil')
                    ->placeholder('-'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'scheduled' => 'Sudah Booking',
                        'ongoing' => 'Sedang Jalan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
                \Filament\Actions\Action::make('viewLaporan')
                    ->label('View Laporan')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(fn () => route('laporan.pesanan'))
                    ->openUrlInNewTab(),
                \Filament\Actions\Action::make('downloadCsv')
                    ->label('Download CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('secondary')
                    ->url(fn () => route('laporan.pesanan.csv'))
                    ->openUrlInNewTab(),
                \Filament\Actions\Action::make('downloadExcel')
                    ->label('Download Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn () => route('laporan.pesanan.excel'))
                    ->openUrlInNewTab(),
            ]);
    }
}
