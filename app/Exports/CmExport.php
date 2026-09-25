<?php

namespace App\Exports;

use App\Models\CmPengajuan;
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

class CmExport implements FromCollection, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithMapping
{
    protected int $month;
    protected int $year;
    protected int $counter = 0;

    public function __construct(int $month, int $year)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    public function collection()
    {
        return CmPengajuan::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function map($cm): array
    {
        $this->counter++;

        $buktiCell = $cm->bukti_transfer
            ? url('storage/' . $cm->bukti_transfer)
            : '-';

        return [
            $this->counter,                                          // No
            $cm->tempat_tanggal ?? '-',                             // Tempat & Tanggal
            $cm->nama_site ?? '-',                                  // Nama Site
            $cm->rincian_kebutuhan ?? '-',                          // Rincian Kebutuhan
            'Rp ' . number_format($cm->total ?? 0, 0, ',', '.'),   // Total Dana
            $buktiCell,                                              // Bukti Transfer
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Tempat & Tanggal',
            'Nama Site',
            'Rincian Kebutuhan',
            'Total Dana (Rp)',
            'Bukti Transfer',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Auto-wrap text for all data rows
        $sheet->getStyle('A1:F' . ($this->counter + 1))
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
            'B' => 25,  // Tempat & Tanggal
            'C' => 35,  // Nama Site
            'D' => 50,  // Rincian Kebutuhan
            'E' => 22,  // Total Dana
            'F' => 55,  // Bukti Transfer
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

        return 'CM ' . ($bulanIndo[$this->month] ?? $this->month) . ' ' . $this->year;
    }
}
