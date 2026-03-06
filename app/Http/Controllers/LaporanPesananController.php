<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class LaporanPesananController extends Controller
{
    // Dashboard ringkasan
    public function dashboard(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', date('m'));

        $totalBulan = Order::whereYear('trip_date', $tahun)
            ->whereMonth('trip_date', $bulan)
            ->count();
        $totalTahun = Order::whereYear('trip_date', $tahun)
            ->count();

        return view('pages.dashboard-laporan', [
            'totalBulan' => $totalBulan,
            'totalTahun' => $totalTahun,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    // Tabel laporan
    public function laporan(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', null);
        $query = Order::whereYear('trip_date', $tahun);
        if ($bulan) {
            $query->whereMonth('trip_date', $bulan);
        }
        $orders = $query->orderBy('trip_date', 'desc')->get();
        return view('pages.laporan-pesanan', [
            'orders' => $orders,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    // Export CSV
    public function exportCsv(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', null);
        return Excel::download(new OrdersExport($tahun, $bulan), 'laporan-pesanan.csv');
    }

    // Export Excel
    public function exportExcel(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));
        $bulan = $request->input('bulan', null);
        return Excel::download(new OrdersExport($tahun, $bulan), 'laporan-pesanan.xlsx');
    }
}
