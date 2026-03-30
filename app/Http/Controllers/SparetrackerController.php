<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sparetracker;
use App\Models\Site;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LogTrackerImport;
use App\Exports\LogTrackerExport;

class SparetrackerController extends Controller
{
    public function index(Request $request)
    {
        $query = Sparetracker::query();

        if ($request->search) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('sn', 'like', "%{$searchTerm}%")
                  ->orWhere('nama_perangkat', 'like', "%{$searchTerm}%")
                  ->orWhere('lokasi_realtime', 'like', "%{$searchTerm}%")
                  ->orWhere('kabupaten', 'like', "%{$searchTerm}%");
            });
        }

        // Filter Kondisi
        if ($request->kondisi) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter Tanggal Masuk
        if ($request->tgl_masuk_mulai) {
            $query->whereDate('tanggal_masuk', '>=', $request->tgl_masuk_mulai);
        }
        if ($request->tgl_masuk_selesai) {
            $query->whereDate('tanggal_masuk', '<=', $request->tgl_masuk_selesai);
        }

        // Filter Tanggal Keluar
        if ($request->tgl_keluar_mulai) {
            $query->whereDate('tanggal_keluar', '>=', $request->tgl_keluar_mulai);
        }
        if ($request->tgl_keluar_selesai) {
            $query->whereDate('tanggal_keluar', '<=', $request->tgl_keluar_selesai);
        }

        // Statistik
        $totalSpare = Sparetracker::count();
        $countBaik  = Sparetracker::where('kondisi', 'BAIK')->count();
        $countRusak = Sparetracker::where('kondisi', 'RUSAK')->count();
        $countBaru  = Sparetracker::where('kondisi', 'BARU')->count();

        $spare_data = $query->latest()->paginate(50)->withQueryString();

        return view('sparetracker', [
            'spare_data' => $spare_data,
            'totalSpare' => $totalSpare,
            'countBaik' => $countBaik,
            'countRusak' => $countRusak,
            'countBaru' => $countBaru
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new LogTrackerImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor.');
    }

    public function export()
    {
        return Excel::download(new LogTrackerExport, 'logtracker.xlsx');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sn' => 'required|string|max:255',
            'nama_perangkat' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'pengadaan_by' => 'nullable|string|max:255',
            'lokasi_asal' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'bulan_masuk' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'status_penggunaan_sparepart' => 'nullable|string|max:255',
            'lokasi_realtime' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'bulan_keluar' => 'nullable|string|max:255',
            'tanggal_keluar' => 'nullable|date',
            'layanan_ai' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $spare = Sparetracker::create($validated);

        $this->syncSiteSN($spare);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $data = Sparetracker::findOrFail($request->id);

        $validated = $request->validate([
            'sn' => 'required|string|max:255',
            'nama_perangkat' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'kondisi' => 'nullable|string|max:255',
            'pengadaan_by' => 'nullable|string|max:255',
            'lokasi_asal' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'bulan_masuk' => 'nullable|string|max:255',
            'tanggal_masuk' => 'nullable|date',
            'status_penggunaan_sparepart' => 'nullable|string|max:255',
            'lokasi_realtime' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'bulan_keluar' => 'nullable|string|max:255',
            'tanggal_keluar' => 'nullable|date',
            'layanan_ai' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data->update($validated);

        $this->syncSiteSN($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $data = Sparetracker::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    /**
     * Sinkron SN ke tabel sites berdasarkan lokasi_realtime = sitename
     */
    private function syncSiteSN(Sparetracker $spare)
    {
        if (!$spare->lokasi_realtime) {
            return;
        }

        $site = Site::where('sitename', $spare->lokasi_realtime)->first();

        if (!$site) {
            return;
        }

        $jenis = strtoupper(trim((string) $spare->jenis));

        switch ($jenis) {
            case 'MODEM':
                $site->sn_modem = $spare->sn;
                break;

            case 'ROUTER':
                $site->sn_router = $spare->sn;
                break;

            case 'SWITCH':
                $site->sn_switch = $spare->sn;
                break;

            case 'AP1':
            case 'ACCESS POINT 1':
            case 'AP 1':
                $site->sn_ap1 = $spare->sn;
                break;

            case 'AP2':
            case 'ACCESS POINT 2':
            case 'AP 2':
                $site->sn_ap2 = $spare->sn;
                break;

            case 'STAVOL':
            case 'STABILIZER':
                $site->sn_stabilizer = $spare->sn;
                break;

            default:
                return;
        }

        $site->save();
    }
}