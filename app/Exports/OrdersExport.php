<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    protected $tahun;
    protected $bulan;

    public function __construct($tahun, $bulan = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $query = Order::whereYear('trip_date', $this->tahun);
        if ($this->bulan) {
            $query->whereMonth('trip_date', $this->bulan);
        }
        return $query->orderBy('trip_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID', 'Tipe', 'Item', 'Tanggal Mulai', 'Tanggal Selesai', 'Pelanggan', 'Total Harga', 'Status'
        ];
    }
}
