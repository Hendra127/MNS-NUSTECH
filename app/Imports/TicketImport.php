<?php

namespace App\Imports;

use App\Models\Ticket;
use App\Models\Site; // Pastikan ini model Site Anda
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class TicketImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // 1. Cari data Site di database berdasarkan SITE ID dari Excel
        // Kita gunakan 'site_id' dari excel untuk mencari di kolom 'site_id' tabel sites
        $site = Site::where('site_id', $row['site_id'])->first();

        // 2. PROTEKSI: Jika site tidak ditemukan, kita punya dua pilihan:
        // Pilihan A: Lewati baris ini (return null)
        // Pilihan B: Berikan nilai default atau buat error log.
        if (!$site) {
            // Jika Anda ingin tetap memasukkan data meskipun site_id tidak ketemu (TIDAK DISARANKAN jika DB ketat)
            // Tapi karena error Anda adalah 'Integrity constraint violation', maka baris ini WAJIB ada di DB.
            return null; 
        }

        // 3. Konversi Tanggal
        $tanggalRekap = null;
        if (isset($row['tanggal_rekap']) && !empty($row['tanggal_rekap'])) {
            try {
                if (is_numeric($row['tanggal_rekap'])) {
                    $tanggalRekap = Date::excelToDateTimeObject($row['tanggal_rekap'])->format('Y-m-d');
                } else {
                    $tanggalRekap = Carbon::parse(str_replace('/', '-', $row['tanggal_rekap']))->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $tanggalRekap = now()->format('Y-m-d');
            }
        }

        return new Ticket([
            'site_id'        => $site->id,            // Mengambil ID (Primary Key) dari tabel sites
            'site_code'      => $row['site_id'],      // SITE ID dari excel disimpan ke site_code
            'nama_site'      => $row['nama_site'] ?? $site->nama_site,
            'provinsi'       => $row['provinsi'] ?? $site->provinsi,
            'kabupaten'      => $row['kabupaten'] ?? $site->kabupaten,
            'kategori'       => $row['kategori'],
            'tanggal_rekap'  => $tanggalRekap,
            'bulan_open'     => $row['bulan_open'] ?? Carbon::parse($tanggalRekap)->format('F'),
            'status'         => 'open',
            'status_tiket'   => $row['status_tiket'] ?? 'Critical',
            'kendala'        => $row['kendala'] ?? '-',
            'detail_problem' => $row['detail_problem'] ?? '-',
            'evidence'       => $row['evidence'] ?? null,
            'plan_actions'   => $row['plan_actions'] ?? null,
            'ce'             => $row['ce'] ?? '-',
        ]);
    }
}