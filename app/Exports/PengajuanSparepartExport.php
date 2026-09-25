<?php

namespace App\Exports;

use App\Models\PengajuanSparepart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PengajuanSparepartExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithMapping
{
    protected int $month;
    protected int $year;
    protected string $type;
    protected int $counter = 0;

    public function __construct(int $month, int $year, string $type)
    {
        $this->month = $month;
        $this->year  = $year;
        $this->type  = $type; // 'Pembelian Baru' or 'Repair Perangkat'
    }

    public function collection()
    {
        return PengajuanSparepart::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->where('tipe_pengajuan', $this->type)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function map($pengajuan): array
    {
        $this->counter++;

        $detailPerangkat = [];
        $snList = [];

        if (is_array($pengajuan->items)) {
            foreach ($pengajuan->items as $item) {
                $nama = $item['perangkat'] ?? '-';
                $qty  = $item['qty'] ?? 1;
                $sn   = $item['sn'] ?? '-';

                $detailPerangkat[] = "- {$nama} (Qty: {$qty})";
                if ($sn && $sn !== '-') {
                    $snList[] = "- {$sn}";
                }
            }
        }

        $detailStr = count($detailPerangkat) > 0 ? implode("\n", $detailPerangkat) : '-';
        $snStr     = count($snList) > 0 ? implode("\n", $snList) : '-';

        return [
            $this->counter,                                                 // No
            $pengajuan->tempat_tanggal ?? '-',                              // Tanggal
            $detailStr,                                                     // Detail Perangkat
            $snStr,                                                         // SN
            'Rp ' . number_format($pengajuan->grand_total ?? 0, 0, ',', '.'), // Total Dana
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Detail Perangkat',
            'SN',
            'Total Dana (Rp)',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Auto-wrap text for all data rows
        $sheet->getStyle('A1:E' . ($this->counter + 1))
            ->getAlignment()->setWrapText(true);

        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1D4ED8'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFBFDBFE'],
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,   // No
            'B' => 25,  // Tanggal
            'C' => 50,  // Detail Perangkat
            'D' => 30,  // SN
            'E' => 22,  // Total Dana
        ];
    }

    public function title(): string
    {
        $bulanIndo = [
            1  => 'Januari', 2  => 'Februari', 3  => 'Maret',
            4  => 'April',   5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',    8  => 'Agustus',   9  => 'September',
            10 => 'Oktober', 11 => 'November',  12 => 'Desember',
        ];

        $typeLabel = $this->type === 'Repair Perangkat' ? 'Repair' : 'Pembelian';
        return "Pengajuan {$typeLabel} " . ($bulanIndo[$this->month] ?? $this->month);
    }
}
