<?php

namespace App\Imports;
 
use App\Models\PMLiberta;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date; 

class PMLibertaImport implements OnEachRow, WithHeadingRow, SkipsEmptyRows
{
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $rowArray = $row->toArray();

        // Skip jika site_id kosong
        if (empty($rowArray['site_id'])) {
            return;
        }

        // Fungsi untuk menangani konversi tanggal Excel
        $tanggalTerformat = null;
        if (isset($rowArray['date'])) {
            try {
                if (is_numeric($rowArray['date'])) {
                    $tanggalTerformat = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rowArray['date'])->format('Y-m-d');
                } else {
                    $cleanDate = str_replace('/', '-', $rowArray['date']);
                    $tanggalTerformat = \Carbon\Carbon::parse($cleanDate)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                try {
                    $tanggalTerformat = \Carbon\Carbon::createFromFormat('d-m-Y', str_replace('/', '-', $rowArray['date']))->format('Y-m-d');
                } catch (\Exception $e2) {
                    $tanggalTerformat = null;
                }
            }
        }

        // --- EKSTRAKSI HYPERLINK ---
        $filePm = $rowArray['file_pm'] ?? $rowArray['link'] ?? $rowArray['url'] ?? null;

        // Ambil worksheet untuk mencari hyperlink asli di sel
        $sheet = $row->getDelegate()->getWorksheet();
        $rowIndex = $row->getIndex();
        
        // Cari hyperlink di seluruh kolom pada baris ini
        $cellIterator = $sheet->getRowIterator($rowIndex, $rowIndex)->current()->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(true); 

        foreach ($cellIterator as $cell) {
            if ($cell->hasHyperlink()) {
                $url = $cell->getHyperlink()->getUrl();
                // Jika link mengandung 'drive.google.com', gunakan sebagai file_pm
                if (str_contains($url, 'drive.google.com')) {
                    $filePm = $url;
                    break;
                }
            }
        }

        // Simpan atau Update data
        PMLiberta::updateOrCreate(
            [
                'site_id'  => $rowArray['site_id'],
                'date'     => $tanggalTerformat,
                'kategori' => $rowArray['kategori'] ?? null,
            ],
            [
                'nama_lokasi' => $rowArray['nama_lokasi'] ?? null,
                'provinsi'    => $rowArray['provinsi'] ?? null,
                'kabupaten'   => $rowArray['kabupaten_kota'] ?? $rowArray['kabupaten'] ?? null,
                'pic_ce'      => $rowArray['pic_ce'] ?? null,
                'month'       => $rowArray['month'] ?? null,
                'status'      => $rowArray['status'] ?? null,
                'week'        => $rowArray['week'] ?? null,
                'file_pm'     => $filePm,
            ]
        );
    }
}