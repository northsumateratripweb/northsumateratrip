<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class LaporanPesananController extends Controller
{
    /**
     * Get a typed month/year query with all relations.
     */
    protected function buildQuery(?int $year = null, ?int $month = null)
    {
        $query = Order::with(['product', 'vehicle', 'rentalPackage'])
            ->orderByDesc('created_at');

        if ($year) {
            $query->whereYear('created_at', $year);
        }
        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        return $query;
    }

    /**
     * Dashboard ringkasan laporan — accessible as standalone page.
     */
    public function dashboard(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = $request->input('bulan') ? (int) $request->input('bulan') : (int) now()->month;

        // Monthly stats
        $bulanan = $this->buildQuery($tahun, $bulan)->get();
        $tahunan = $this->buildQuery($tahun)->get();

        $statsBulan = $this->computeStats($bulanan);
        $statsTahun = $this->computeStats($tahunan);

        // Monthly chart
        $grafikBulanan = [];
        for ($m = 1; $m <= 12; $m++) {
            $orders = Order::whereYear('created_at', $tahun)->whereMonth('created_at', $m)->where('status', '!=', 'cancelled');
            $grafikBulanan[] = [
                'bulan'    => Carbon::create($tahun, $m, 1)->locale('id')->isoFormat('MMM'),
                'pesanan'  => $orders->count(),
                'revenue'  => $orders->sum('total_price'),
            ];
        }

        $availableYears = $this->getAvailableYears();

        return view('pages.dashboard-laporan', compact(
            'tahun', 'bulan', 'statsBulan', 'statsTahun', 'grafikBulanan', 'availableYears'
        ));
    }

    /**
     * Laporan halaman tabel lengkap.
     */
    public function laporan(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = $request->input('bulan') !== null ? (int) $request->input('bulan') : null;

        $orders = $this->buildQuery($tahun, $bulan)->get();

        // Group by month for yearly view
        $groupedByMonth = null;
        if (!$bulan) {
            $groupedByMonth = $orders->groupBy(fn ($o) => $o->created_at->format('n'));
        }

        $statsBulan = $bulan ? $this->computeStats($orders) : null;
        $statsTahun = $this->computeStats($this->buildQuery($tahun)->get());

        $availableYears = $this->getAvailableYears();

        $namaBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember',
        ];

        return view('pages.laporan-pesanan', compact(
            'orders', 'tahun', 'bulan', 'groupedByMonth',
            'statsBulan', 'statsTahun', 'availableYears', 'namaBulan'
        ));
    }

    /**
     * Export CSV
     */
    public function exportCsv(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = $request->input('bulan') ? (int) $request->input('bulan') : null;

        $namaBulan = $bulan ? '-bulan-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) : '';
        $filename  = 'laporan-pesanan-' . $tahun . $namaBulan . '.csv';

        return Excel::download(new OrdersExport($tahun, $bulan), $filename, \Maatwebsite\Excel\Excel::CSV, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Export Excel
     */
    public function exportExcel(Request $request)
    {
        $tahun = (int) $request->input('tahun', now()->year);
        $bulan = $request->input('bulan') ? (int) $request->input('bulan') : null;

        $namaBulan = $bulan ? '-bulan-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) : '';
        $filename  = 'laporan-pesanan-' . $tahun . $namaBulan . '.xlsx';

        return Excel::download(new OrdersExport($tahun, $bulan), $filename);
    }

    /**
     * Compute aggregate stats from a collection of orders.
     */
    protected function computeStats($orders): array
    {
        return [
            'total'     => $orders->count(),
            'revenue'   => $orders->where('status', '!=', 'cancelled')->sum('total_price'),
            'tour'      => $orders->filter(fn ($o) => $o->product_id && !$o->vehicle_id && !$o->rental_package_id)->count(),
            'rental'    => $orders->filter(fn ($o) => (bool) $o->rental_package_id)->count(),
            'car'       => $orders->filter(fn ($o) => (bool) $o->vehicle_id)->count(),
            'pending'   => $orders->where('status', 'pending')->count(),
            'confirmed' => $orders->where('status', 'confirmed')->count(),
            'completed' => $orders->where('status', 'completed')->count(),
            'cancelled' => $orders->where('status', 'cancelled')->count(),
            'paid'      => $orders->where('payment_status', 'paid')->count(),
            'unpaid'    => $orders->where('payment_status', 'unpaid')->count(),
        ];
    }

    /**
     * Get available years for filtering, compatible with SQLite/MySQL.
     */
    protected function getAvailableYears(): array
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
