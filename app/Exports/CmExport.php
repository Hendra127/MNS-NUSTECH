<?php

namespace App\Exports;

use App\Models\CmPengajuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class CmExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithColumnWidths, WithCustomStartCell, WithDrawings, WithEvents
{
    protected int $month;
    protected int $year;
    protected ?string $kategori;
    protected int $counter = 0;
    protected $dataCollection;

    public function __construct(int $month, int $year, ?string $kategori = null)
    {
        $this->month    = $month;
        $this->year     = $year;
        $this->kategori = $kategori;
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function collection()
    {
        $query = CmPengajuan::whereMonth('created_at', $this->month)
            ->whereYear('created_at', $this->year);

        if (!empty($this->kategori)) {
            $query->where('kategori', $this->kategori);
        }

        $this->dataCollection = $query->orderBy('created_at', 'asc')->get();
        return $this->dataCollection;
    }

    public function map($cm): array
    {
        $this->counter++;

        return [
            $this->counter,                                        // No
            $cm->kategori ?? '-',                                 // Kategori
            $cm->tempat_tanggal ?? '-',                           // Tempat & Tanggal
            $cm->nama_site ?? '-',                                // Nama Site
            $cm->rincian_kebutuhan ?? '-',                        // Rincian Kebutuhan
            'Rp ' . number_format($cm->total ?? 0, 0, ',', '.'), // Total Dana
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Tempat & Tanggal',
            'Nama Site',
            'Rincian Kebutuhan',
            'Total Dana (Rp)',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 14,  // Kategori
            'C' => 25,  // Tempat & Tanggal
            'D' => 35,  // Nama Site
            'E' => 50,  // Rincian Kebutuhan
            'F' => 22,  // Total Dana
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

        $katStr = $this->kategori ? ' ' . $this->kategori : '';
        return 'CM' . $katStr . ' ' . ($bulanIndo[$this->month] ?? $this->month) . ' ' . $this->year;
    }

    public function drawings()
    {
        $drawings = [];

        // 1. Logo Nustech (Centered in Header Row 1)
        $logoPath = public_path('assets/img/logo2.jpg');
        if (!file_exists($logoPath)) {
            $logoPath = public_path('assets/img/logonustech.png');
        }
        if (file_exists($logoPath)) {
            $logo = new Drawing();
            $logo->setName('Logo Nustech');
            $logo->setDescription('Logo Nustech');
            $logo->setPath($logoPath);
            $logo->setHeight(55);
            $logo->setCoordinates('D1');
            $logo->setOffsetX(75);
            $logo->setOffsetY(3);
            $drawings[] = $logo;
        }

        $rowCount = $this->dataCollection ? count($this->dataCollection) : 0;
        $totalRow = 5 + $rowCount + 1;
        $R = $totalRow + 3;

        // 2. Pemohon TTD (Centered over A..C)
        $pemohonPath = public_path('assets/img/ttd/pemohon.png');
        if (file_exists($pemohonPath)) {
            $d = new Drawing();
            $d->setName('TTD Pemohon');
            $d->setPath($pemohonPath);
            $d->setHeight(52);
            $d->setCoordinates('A' . ($R + 1));
            $d->setOffsetX(125);
            $drawings[] = $d;
        }

        // 3. Manager TTD (Centered over E..F)
        $managerPath = public_path('assets/img/ttd/manager.png');
        if (file_exists($managerPath)) {
            $d = new Drawing();
            $d->setName('TTD Manager');
            $d->setPath($managerPath);
            $d->setHeight(52);
            $d->setCoordinates('E' . ($R + 1));
            $d->setOffsetX(215);
            $drawings[] = $d;
        }

        $R2 = $R + 7;
        // 4. Accounting TTD (Centered over A..C)
        $accPath = public_path('assets/img/ttd/accounting.png');
        if (file_exists($accPath)) {
            $d = new Drawing();
            $d->setName('TTD Accounting');
            $d->setPath($accPath);
            $d->setHeight(52);
            $d->setCoordinates('A' . ($R2 + 1));
            $d->setOffsetX(125);
            $drawings[] = $d;
        }

        // 5. Direktur TTD (Centered over E..F)
        $dirPath = public_path('assets/img/ttd/direktur.png');
        if (file_exists($dirPath)) {
            $d = new Drawing();
            $d->setName('TTD Direktur');
            $d->setPath($dirPath);
            $d->setHeight(52);
            $d->setCoordinates('E' . ($R2 + 1));
            $d->setOffsetX(215);
            $drawings[] = $d;
        }

        $R3 = $R2 + 7;
        // 6. Penasihat TTD (Centered over C..D)
        $penPath = public_path('assets/img/ttd/penasihat.png');
        if (file_exists($penPath)) {
            $d = new Drawing();
            $d->setName('TTD Penasihat');
            $d->setPath($penPath);
            $d->setHeight(52);
            $d->setCoordinates('C' . ($R3 + 1));
            $d->setOffsetX(172);
            $drawings[] = $d;
        }

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // 1. Hilangkan garis grid (Blank Putih)
                $sheet->setShowGridlines(false);

                // Month Indo map
                $bulanIndo = [
                    1  => 'Januari', 2  => 'Februari', 3  => 'Maret',
                    4  => 'April',   5  => 'Mei',       6  => 'Juni',
                    7  => 'Juli',    8  => 'Agustus',   9  => 'September',
                    10 => 'Oktober', 11 => 'November',  12 => 'Desember',
                ];

                $monthName = $bulanIndo[$this->month] ?? $this->month;
                $katLabel  = $this->kategori ? 'KATEGORI ' . $this->kategori : 'SEMUA KATEGORI';

                // Kop Title and Subtitle at Row 2 and 3
                $sheet->mergeCells('A2:F2');
                $sheet->setCellValue('A2', 'FORMULIR PENGAJUAN CORRECTIVE / PREVENTIVE MAINTENANCE');
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(13)->setColor(new Color('FF1E3A8A'));
                $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('A3:F3');
                $sheet->setCellValue('A3', 'PERIODE: ' . strtoupper($monthName) . ' ' . $this->year . ' | ' . $katLabel);
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(10)->setColor(new Color('FF4B5563'));
                $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Set row heights for header
                $sheet->getRowDimension(1)->setRowHeight(60);
                $sheet->getRowDimension(2)->setRowHeight(24);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(12);
                $sheet->getRowDimension(5)->setRowHeight(28); // Table Header

                $rowCount = $this->dataCollection ? count($this->dataCollection) : 0;
                $lastDataRow = 5 + $rowCount;

                // Table Header Styles (Row 5)
                $sheet->getStyle('A5:F5')->applyFromArray([
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
                ]);

                // Table Data Styles (Row 6 to $lastDataRow)
                if ($rowCount > 0) {
                    $sheet->getStyle("A6:F{$lastDataRow}")->applyFromArray([
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color'       => ['argb' => 'FFD1D5DB'],
                            ],
                        ],
                    ]);

                    // Alignments
                    $sheet->getStyle("A6:B{$lastDataRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle("F6:F{$lastDataRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                }

                // Total Row (Row $lastDataRow + 1)
                $totalRow = $lastDataRow + 1;
                $sheet->getRowDimension($totalRow)->setRowHeight(24);
                $sheet->mergeCells("A{$totalRow}:E{$totalRow}");
                $sheet->setCellValue("A{$totalRow}", 'TOTAL DANA');
                $sheet->getStyle("A{$totalRow}")->getFont()->setBold(true);
                $sheet->getStyle("A{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);

                // Calculate total sum
                $totalSum = $this->dataCollection ? $this->dataCollection->sum('total') : 0;
                $sheet->setCellValue("F{$totalRow}", 'Rp ' . number_format($totalSum, 0, ',', '.'));
                $sheet->getStyle("F{$totalRow}")->getFont()->setBold(true);
                $sheet->getStyle("F{$totalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT)->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle("A{$totalRow}:F{$totalRow}")->applyFromArray([
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF3F4F6'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FF9CA3AF'],
                        ],
                    ],
                ]);

                // Signature Section
                $R = $totalRow + 3; // Start row for TTD 1

                // Row heights for TTD images
                $sheet->getRowDimension($R)->setRowHeight(20);
                $sheet->getRowDimension($R + 1)->setRowHeight(20);
                $sheet->getRowDimension($R + 2)->setRowHeight(20);
                $sheet->getRowDimension($R + 3)->setRowHeight(20);
                $sheet->getRowDimension($R + 4)->setRowHeight(22);
                $sheet->getRowDimension($R + 5)->setRowHeight(20);
                $sheet->getRowDimension($R + 6)->setRowHeight(15);

                // TTD 1: Pemohon (A..C) & Manager (E..F)
                $sheet->mergeCells("A{$R}:C{$R}");
                $sheet->setCellValue("A{$R}", 'Pemohon,');
                $sheet->getStyle("A{$R}")->getFont()->setSize(10);
                $sheet->getStyle("A{$R}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("E{$R}:F{$R}");
                $sheet->setCellValue("E{$R}", 'Diverifikasi,');
                $sheet->getStyle("E{$R}")->getFont()->setSize(10);
                $sheet->getStyle("E{$R}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("A" . ($R + 4) . ":C" . ($R + 4));
                $sheet->setCellValue("A" . ($R + 4), 'Rossie Maulana Septian, S.Kom');
                $sheet->getStyle("A" . ($R + 4))->getFont()->setBold(true)->setUnderline(true);
                $sheet->getStyle("A" . ($R + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("A" . ($R + 5) . ":C" . ($R + 5));
                $sheet->setCellValue("A" . ($R + 5), 'NOC Leader');
                $sheet->getStyle("A" . ($R + 5))->getFont()->setBold(true);
                $sheet->getStyle("A" . ($R + 5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("E" . ($R + 4) . ":F" . ($R + 4));
                $sheet->setCellValue("E" . ($R + 4), 'Dimas Farid Awaludin, S.Kom');
                $sheet->getStyle("E" . ($R + 4))->getFont()->setBold(true)->setUnderline(true);
                $sheet->getStyle("E" . ($R + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("E" . ($R + 5) . ":F" . ($R + 5));
                $sheet->setCellValue("E" . ($R + 5), 'Manager');
                $sheet->getStyle("E" . ($R + 5))->getFont()->setBold(true);
                $sheet->getStyle("E" . ($R + 5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                // TTD 2: Accounting (A..C) & Direktur (E..F)
                $R2 = $R + 7;
                $sheet->getRowDimension($R2)->setRowHeight(20);
                $sheet->getRowDimension($R2 + 1)->setRowHeight(20);
                $sheet->getRowDimension($R2 + 2)->setRowHeight(20);
                $sheet->getRowDimension($R2 + 3)->setRowHeight(20);
                $sheet->getRowDimension($R2 + 4)->setRowHeight(22);
                $sheet->getRowDimension($R2 + 5)->setRowHeight(20);
                $sheet->getRowDimension($R2 + 6)->setRowHeight(15);

                $sheet->mergeCells("A{$R2}:C{$R2}");
                $sheet->setCellValue("A{$R2}", 'Diverifikasi,');
                $sheet->getStyle("A{$R2}")->getFont()->setSize(10);
                $sheet->getStyle("A{$R2}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("E{$R2}:F{$R2}");
                $sheet->setCellValue("E{$R2}", 'Disetujui,');
                $sheet->getStyle("E{$R2}")->getFont()->setSize(10);
                $sheet->getStyle("E{$R2}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("A" . ($R2 + 4) . ":C" . ($R2 + 4));
                $sheet->setCellValue("A" . ($R2 + 4), 'Desi Harisna Ariani');
                $sheet->getStyle("A" . ($R2 + 4))->getFont()->setBold(true)->setUnderline(true);
                $sheet->getStyle("A" . ($R2 + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("A" . ($R2 + 5) . ":C" . ($R2 + 5));
                $sheet->setCellValue("A" . ($R2 + 5), 'Head of Accounting');
                $sheet->getStyle("A" . ($R2 + 5))->getFont()->setBold(true);
                $sheet->getStyle("A" . ($R2 + 5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("E" . ($R2 + 4) . ":F" . ($R2 + 4));
                $sheet->setCellValue("E" . ($R2 + 4), 'Baiq Nana Erina, A.Md');
                $sheet->getStyle("E" . ($R2 + 4))->getFont()->setBold(true)->setUnderline(true);
                $sheet->getStyle("E" . ($R2 + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("E" . ($R2 + 5) . ":F" . ($R2 + 5));
                $sheet->setCellValue("E" . ($R2 + 5), 'Plt. Direktur');
                $sheet->getStyle("E" . ($R2 + 5))->getFont()->setBold(true);
                $sheet->getStyle("E" . ($R2 + 5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                // TTD 3: Penasihat (C..D)
                $R3 = $R2 + 7;
                $sheet->getRowDimension($R3)->setRowHeight(20);
                $sheet->getRowDimension($R3 + 1)->setRowHeight(20);
                $sheet->getRowDimension($R3 + 2)->setRowHeight(20);
                $sheet->getRowDimension($R3 + 3)->setRowHeight(20);
                $sheet->getRowDimension($R3 + 4)->setRowHeight(22);
                $sheet->getRowDimension($R3 + 5)->setRowHeight(20);

                $sheet->mergeCells("C{$R3}:D{$R3}");
                $sheet->setCellValue("C{$R3}", 'Mengetahui,');
                $sheet->getStyle("C{$R3}")->getFont()->setSize(10);
                $sheet->getStyle("C{$R3}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("C" . ($R3 + 4) . ":D" . ($R3 + 4));
                $sheet->setCellValue("C" . ($R3 + 4), 'Raden Yuniarta Alba, S.Kom');
                $sheet->getStyle("C" . ($R3 + 4))->getFont()->setBold(true)->setUnderline(true);
                $sheet->getStyle("C" . ($R3 + 4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells("C" . ($R3 + 5) . ":D" . ($R3 + 5));
                $sheet->setCellValue("C" . ($R3 + 5), 'Penasihat');
                $sheet->getStyle("C" . ($R3 + 5))->getFont()->setBold(true);
                $sheet->getStyle("C" . ($R3 + 5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
