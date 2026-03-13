<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPiket;
use App\Models\Shift;
use Carbon\Carbon;

class PiketController extends Controller
{
    public function index(Request $request)
{
    // 1. Tangkap bulan dan tahun dari URL, atau gunakan bulan ini sebagai default
    $month = $request->get('month', date('m'));
    $year = $request->get('year', date('Y'));

    // 2. Buat objek Carbon berdasarkan filter tersebut
    $selectedDate = \Carbon\Carbon::createFromDate($year, $month, 1);
    
    $jumlahHari = $selectedDate->daysInMonth;
    $bulanSekarang = $selectedDate->translatedFormat('F');
    $tahunSekarang = $selectedDate->year;

    // 3. Daftar nama statis
    $daftarNama = [
        'Raden Kukuh Ridho Ahadi', 'Hendra Hadi Pratama', 'Andri Pratama',
        'Muhammad Azul', 'Lalu Taufiq Wijaya', 'Aditia Marandika Rachman', 'IWAN VANI'
    ];

    // 4. Ambil data piket berdasarkan bulan & tahun yang dipilih
    $dataPiket = \App\Models\JadwalPiket::whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $year)
                    ->get();

    return view('jadwalpiket', compact('daftarNama', 'dataPiket', 'jumlahHari', 'bulanSekarang', 'tahunSekarang', 'month', 'year'));
}
    public function batchUpdate(Request $request)
    {
        try {
            $updates = $request->input('updates', []);
            
            foreach ($updates as $data) {
                $namaPetugas = trim($data['nama']);
                
                // Cari user berdasarkan Nama (Case-Insensitive)
                $user = \App\Models\User::where('name', 'LIKE', '%' . $namaPetugas . '%')->first();
                
                if (!$user) {
                    continue; // Skip jika user tidak ditemukan
                }

                // JIKA KODE ADALAH 'OFF', HAPUS DATA JADWAL
                if ($data['shift_kode'] === 'OFF') {
                    \App\Models\JadwalPiket::where('user_id', $user->id)
                        ->where('tanggal', $data['tanggal'])
                        ->delete();
                    continue;
                }

                // CARI SHIFT BERDASARKAN KODE
                $shift = \App\Models\Shift::where('kode', $data['shift_kode'])->first();

                if ($shift) {
                    \App\Models\JadwalPiket::updateOrCreate(
                        ['user_id' => $user->id, 'tanggal' => $data['tanggal']],
                        ['shift_id' => $shift->id, 'status' => 'aktif']
                    );
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Semua jadwal berhasil diperbarui.']);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
}