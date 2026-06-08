<?php

namespace App\Filament\Resources\TripSchedules\Pages;

use App\Filament\Resources\TripSchedules\TripScheduleResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTripSchedules extends ListRecords
{
    protected static string $resource = TripScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Jadwal Baru'),
            Action::make('viewLaporan')
                ->label('Laporan')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->url(fn () => route('laporan.pesanan', ['tahun' => now()->year, 'bulan' => now()->month]))
                ->openUrlInNewTab(),
            ActionGroup::make([
                Action::make('downloadCsv')
                    ->label('Export CSV Bulan Ini')
                    ->icon('heroicon-o-document-text')
                    ->url(fn () => route('laporan.pesanan.csv', ['tahun' => now()->year, 'bulan' => now()->month]))
                    ->openUrlInNewTab(),
                Action::make('downloadExcel')
                    ->label('Export Excel Bulan Ini')
                    ->icon('heroicon-o-table-cells')
                    ->url(fn () => route('laporan.pesanan.excel', ['tahun' => now()->year, 'bulan' => now()->month]))
                    ->openUrlInNewTab(),
            ])
                ->label('Export Data')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('gray')
                ->button(),
        ];
    }
}
