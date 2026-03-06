<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected int $tahun;
    protected ?int $bulan;

    public function __construct(int $tahun, ?int $bulan = null)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }

    public function title(): string
    {
        $namaBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April',
            5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus',
            9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember',
        ];

        if ($this->bulan) {
            return 'Laporan ' . ($namaBulan[$this->bulan] ?? $this->bulan) . ' ' . $this->tahun;
        }
        return 'Laporan Tahunan ' . $this->tahun;
    }

    public function collection()
    {
        $query = Order::with(['product', 'vehicle', 'rentalPackage'])
            ->whereYear('created_at', $this->tahun);

        if ($this->bulan) {
            $query->whereMonth('created_at', $this->bulan);
        }

        return $query->orderBy('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'ID Transaksi',
            'Tgl Pesan',
            'Tipe Pesanan',
            'Item / Paket',
            'Nama Pelanggan',
            'Email',
            'No. Telepon',
            'Tgl Mulai Trip',
            'Tgl Selesai Trip',
            'Pax Dewasa',
            'Pax Anak',
            'Total Pax',
            'Total Harga (IDR)',
            'Status Pesanan',
            'Status Bayar',
            'Hotel Category',
            'Hotel 1',
            'Hotel 2',
            'Hotel 3',
            'Hotel 4',
            'Flight Info',
            'Gunakan Drone',
            'Catatan',
        ];
    }

    public function map($order): array
    {
        static $no = 0;
        $no++;

        // Determine type
        if ($order->vehicle_id) {
            $tipe = 'Rental Mobil';
        } elseif ($order->rental_package_id) {
            $tipe = 'Paket Rental';
        } else {
            $tipe = 'Paket Wisata';
        }

        $item = $order->vehicle?->name
            ?? $order->rentalPackage?->name
            ?? $order->product?->name
            ?? '-';

        return [
            $no,
            $order->transaction_id ?? '-',
            $order->created_at?->format('d/m/Y H:i'),
            $tipe,
            $item,
            $order->customer_name,
            $order->customer_email ?? '-',
            $order->customer_phone,
            $order->trip_date?->format('d/m/Y') ?? '-',
            $order->trip_end_date?->format('d/m/Y') ?? '-',
            $order->pax_adult,
            $order->pax_child,
            $order->quantity,
            $order->total_price,
            ucfirst($order->status),
            match($order->payment_status) {
                'paid'    => 'Lunas',
                'partial' => 'DP (Sebagian)',
                default   => 'Belum Lunas',
            },
            $order->hotel_category ?? '-',
            $order->hotel_1 ?? '-',
            $order->hotel_2 ?? '-',
            $order->hotel_3 ?? '-',
            $order->hotel_4 ?? '-',
            $order->flight_info ?? '-',
            $order->use_drone ? 'Ya' : 'Tidak',
            $order->notes ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 18,
            'C' => 18,
            'D' => 15,
            'E' => 30,
            'F' => 25,
            'G' => 28,
            'H' => 18,
            'I' => 15,
            'J' => 15,
            'K' => 12,
            'L' => 12,
            'M' => 12,
            'N' => 20,
            'O' => 18,
            'P' => 18,
            'Q' => 15,
            'R' => 20,
            'S' => 20,
            'T' => 20,
            'U' => 20,
            'V' => 20,
            'W' => 15,
            'X' => 35,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E40AF'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
