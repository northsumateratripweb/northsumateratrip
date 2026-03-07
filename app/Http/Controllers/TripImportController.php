<?php

namespace App\Http\Controllers;

use App\Models\TripImport;
use Illuminate\Http\Request;

class TripImportController extends Controller
{
    /**
     * Import CSV trip data into the database.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020|max:2030',
        ]);

        $file = $request->file('csv_file');
        $filename = $file->getClientOriginalName();
        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        // Delete existing data for same month/year from same file source
        TripImport::where('bulan', $bulan)->where('tahun', $tahun)->delete();

        $handle = fopen($file->getRealPath(), 'r');
        $header = null;
        $imported = 0;

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            // First row is header
            if ($header === null) {
                $header = $row;
                continue;
            }

            // Skip empty rows (no tanggal and no pelanggan)
            $tanggal   = trim($row[0] ?? '');
            $pelanggan = trim($row[1] ?? '');
            if (empty($tanggal) && empty($pelanggan)) {
                continue;
            }

            // Parse date dd/mm/yyyy
            $parsedDate = null;
            if (!empty($tanggal)) {
                try {
                    $parts = explode('/', $tanggal);
                    if (count($parts) === 3) {
                        $parsedDate = "{$parts[2]}-{$parts[1]}-{$parts[0]}";
                    }
                } catch (\Exception $e) {}
            }

            $harga     = (float) preg_replace('/[^0-9.]/', '', $row[15] ?? 0);
            $deposit   = (float) preg_replace('/[^0-9.]/', '', $row[16] ?? 0);
            $pelunasan = (float) preg_replace('/[^0-9.]/', '', $row[17] ?? 0);

            TripImport::create([
                'tanggal'        => $parsedDate,
                'nama_pelanggan' => $pelanggan ?: null,
                'status'         => trim($row[2] ?? '') ?: null,
                'nomor_hp'       => trim($row[3] ?? '') ?: null,
                'nama_driver'    => trim($row[4] ?? '') ?: null,
                'layanan'        => trim($row[5] ?? '') ?: null,
                'plat_mobil'     => trim($row[6] ?? '') ?: null,
                'jenis_mobil'    => trim($row[7] ?? '') ?: null,
                'drone'          => strtoupper(trim($row[8] ?? 'FALSE')) === 'TRUE',
                'jumlah_hari'    => (int) ($row[9] ?? 1) ?: 1,
                'penumpang'      => ($row[10] ?? null) ? (int) $row[10] : null,
                'hotel_1'        => trim($row[11] ?? '') ?: null,
                'hotel_2'        => trim($row[12] ?? '') ?: null,
                'hotel_3'        => trim($row[13] ?? '') ?: null,
                'hotel_4'        => trim($row[14] ?? '') ?: null,
                'harga'          => $harga,
                'deposit'        => $deposit,
                'pelunasan'      => $pelunasan,
                'tiba'           => trim($row[18] ?? '') ?: null,
                'flight_balik'   => trim($row[19] ?? '') ?: null,
                'source_file'    => $filename,
                'bulan'          => $bulan,
                'tahun'          => $tahun,
            ]);
            $imported++;
        }

        fclose($handle);

        return redirect()->back()->with('success', "Berhasil mengimport {$imported} data trip dari file {$filename}.");
    }
}
