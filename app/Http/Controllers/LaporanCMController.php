<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanCM;
use App\Models\Site;
use Illuminate\Support\Facades\Storage;
use App\Exports\LaporanCMExport;
use App\Imports\LaporanCMImport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanCMController extends Controller
{
    public function index(Request $request)
    {
        $sites = Site::orderBy('sitename')->get();
        $query = LaporanCM::query()->orderBy('created_at', 'desc');

        // Search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('site_id', 'like', "%$search%")
                    ->orWhere('nama_site', 'like', "%$search%")
                    ->orWhere('nama_teknisi', 'like', "%$search%");
            });
        }

        // Filter by laporan_cm
        if ($request->filled('laporan_cm')) {
            $query->where('laporan_cm', $request->laporan_cm);
        }

        // Filter by date range
        if ($request->filled('tgl_mulai')) {
            $query->whereDate('tanggal_on_site', '>=', $request->tgl_mulai);
        }
        if ($request->filled('tgl_selesai')) {
            $query->whereDate('tanggal_on_site', '<=', $request->tgl_selesai);
        }

        $data = $query->get();
        
        // Fetch unique laporan_cm for filter options
        $uniqueReports = LaporanCM::select('laporan_cm')->whereNotNull('laporan_cm')->distinct()->pluck('laporan_cm')->toArray();

        return view('laporancm', compact('sites', 'data', 'uniqueReports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_id' => 'required|string',
            'nama_site' => 'nullable|string',
            'tanggal_on_site' => 'required|date',
            'nama_teknisi' => 'required|string|max:100',
            'laporan_cm' => 'nullable|string',
            'notes' => 'nullable|string',
            'biaya_teknisi' => 'nullable|numeric',
            'foto_on_site' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'bukti_transfer' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $site = Site::where('site_id', $request->site_id)->first();
        if (!$site) {
            return redirect()->back()->with('error', 'Site id tidak ditemukan!')->withInput();
        }

        $data = $request->all();

        // Handle File Uploads
        if ($request->hasFile('foto_on_site')) {
            $data['foto_on_site'] = $request->file('foto_on_site')->store('laporancm/foto', 'public');
        }
        if ($request->hasFile('bukti_transfer')) {
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('laporancm/bukti', 'public');
        }

        LaporanCM::create($data);

        return redirect()->route('laporancm')->with('success', 'Data Laporan CM berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_on_site' => 'required|date',
            'nama_teknisi' => 'required|string|max:100',
            'laporan_cm' => 'nullable|string',
            'notes' => 'nullable|string',
            'biaya_teknisi' => 'nullable|numeric',
            'foto_on_site_update' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'bukti_transfer_update' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $laporan = LaporanCM::findOrFail($id);
        $data = $request->except(['foto_on_site_update', 'bukti_transfer_update']);

        if ($request->hasFile('foto_on_site_update')) {
            if ($laporan->foto_on_site && Storage::disk('public')->exists($laporan->foto_on_site)) {
                Storage::disk('public')->delete($laporan->foto_on_site);
            }
            $data['foto_on_site'] = $request->file('foto_on_site_update')->store('laporancm/foto', 'public');
        }

        if ($request->hasFile('bukti_transfer_update')) {
            if ($laporan->bukti_transfer && Storage::disk('public')->exists($laporan->bukti_transfer)) {
                Storage::disk('public')->delete($laporan->bukti_transfer);
            }
            $data['bukti_transfer'] = $request->file('bukti_transfer_update')->store('laporancm/bukti', 'public');
        }

        $laporan->update($data);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $laporan = LaporanCM::findOrFail($id);
        
        if ($laporan->foto_on_site && Storage::disk('public')->exists($laporan->foto_on_site)) {
            Storage::disk('public')->delete($laporan->foto_on_site);
        }
        
        if ($laporan->bukti_transfer && Storage::disk('public')->exists($laporan->bukti_transfer)) {
            Storage::disk('public')->delete($laporan->bukti_transfer);
        }

        $laporan->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function export()
    {
        return Excel::download(new LaporanCMExport, 'Laporan_CM.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new LaporanCMImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Laporan CM berhasil diimport');
    }
}
