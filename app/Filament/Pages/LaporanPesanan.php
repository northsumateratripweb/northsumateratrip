<?php

namespace App\Filament\Pages;

use App\Models\Order;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use UnitEnum;

class LaporanPesanan extends Page
{
    // Non-static: must match parent's 'protected string $view'
    protected string $view = 'filament.pages.laporan-pesanan';

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Pesanan';
    protected static \UnitEnum|string|null $navigationGroup = 'Pesanan & Jadwal';
    protected static ?int $navigationSort = 99;
    protected static ?string $title = 'Laporan Pesanan';

    public int $selectedYear;
    public ?int $selectedMonth = null;

    public function mount(): void
    {
        $this->selectedYear  = (int) now()->format('Y');
        $this->selectedMonth = (int) now()->format('n');
    }

    // ── Stats for selected period ───────────────────────────────────────────────

    public function getMonthlyStats(): array
    {
        $month = $this->selectedMonth ?? (int) now()->format('n');

        $q = Order::whereYear('created_at', $this->selectedYear)
            ->whereMonth('created_at', $month);

        return [
            'total'     => $q->count(),
            'revenue'   => (clone $q)->where('status', '!=', 'cancelled')->sum('total_price'),
            'tour'      => (clone $q)->whereNotNull('product_id')->whereNull('vehicle_id')->whereNull('rental_package_id')->count(),
            'rental'    => (clone $q)->whereNotNull('rental_package_id')->count(),
            'car'       => (clone $q)->whereNotNull('vehicle_id')->count(),
            'pending'   => (clone $q)->where('status', 'pending')->count(),
            'confirmed' => (clone $q)->where('status', 'confirmed')->count(),
            'completed' => (clone $q)->where('status', 'completed')->count(),
            'cancelled' => (clone $q)->where('status', 'cancelled')->count(),
        ];
    }

    public function getYearlyStats(): array
    {
        $q = Order::whereYear('created_at', $this->selectedYear);

        return [
            'total'   => $q->count(),
            'revenue' => (clone $q)->where('status', '!=', 'cancelled')->sum('total_price'),
            'tour'    => (clone $q)->whereNotNull('product_id')->whereNull('vehicle_id')->whereNull('rental_package_id')->count(),
            'rental'  => (clone $q)->whereNotNull('rental_package_id')->count(),
            'car'     => (clone $q)->whereNotNull('vehicle_id')->count(),
        ];
    }

    // ── Monthly chart breakdown ─────────────────────────────────────────────────

    public function getMonthlyChartData(): array
    {
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $count  = Order::whereYear('created_at', $this->selectedYear)
                ->whereMonth('created_at', $m)
                ->where('status', '!=', 'cancelled')
                ->count();
            $revenue = Order::whereYear('created_at', $this->selectedYear)
                ->whereMonth('created_at', $m)
                ->where('status', '!=', 'cancelled')
                ->sum('total_price');

            $months[] = [
                'month'   => Carbon::create($this->selectedYear, $m, 1)->locale('id')->monthName,
                'orders'  => $count,
                'revenue' => $revenue,
            ];
        }
        return $months;
    }

    // ── Orders list for table ──────────────────────────────────────────────────

    public function getOrdersData()
    {
        $q = Order::with(['product', 'vehicle', 'rentalPackage'])
            ->whereYear('created_at', $this->selectedYear);

        if ($this->selectedMonth) {
            $q->whereMonth('created_at', $this->selectedMonth);
        }

        return $q->orderByDesc('created_at')->get();
    }

    // ── Available years for filter ─────────────────────────────────────────────

    public function getAvailableYears(): array
    {
        $driver = \Illuminate\Support\Facades\DB::getDriverName();
        $query = Order::query();

        if ($driver === 'sqlite') {
            $query->selectRaw('strftime("%Y", created_at) as y');
        } else {
            $query->selectRaw('YEAR(created_at) as y');
        }

        $years = $query->distinct()->orderByDesc('y')->pluck('y')->toArray();

        return empty($years) ? [(int) now()->year] : array_map('intval', $years);
    }
}
