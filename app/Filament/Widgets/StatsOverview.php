<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\RentalSchedule;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $pollingInterval = '5s';


    protected function getStats(): array
    {
        $pendingOrders = Order::where('status', 'pending')->count();
        $monthlyRevenue = Order::where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_price');
        
        $activeFleet = RentalSchedule::where('rental_status', 'booked')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        return [
            Stat::make('Pesanan Pending', $pendingOrders)
                ->description('Butuh konfirmasi segera')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format($monthlyRevenue, 0, ',', '.'))
                ->description('Total dari semua pesanan aktif')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            Stat::make('Armada Aktif', $activeFleet)
                ->description('Unit sedang digunakan hari ini')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),
        ];
    }
}
