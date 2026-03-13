<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogPerangkat;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LogPerangkatImport;
use App\Exports\LogPerangkatExport;

class PergantianController extends Controller
{
    public function index(Request $request)
    {
        $query = LogPerangkat::with('site');

        if ($request->search) {
            $searchTerm = trim($request->search);
            $query->where(function($q) use ($searchTerm) {
                $q->where('perangkat', 'like', "%{$searchTerm}%")
                  ->orWhere('sn_lama', 'like', "%{$searchTerm}%")
                  ->orWhere('sn_baru', 'like', "%{$searchTerm}%")
                  ->orWhereHas('site', function($sq) use ($searchTerm) {
                      $sq->where('site_id', 'like', "%{$searchTerm}%")
                        ->orWhere('sitename', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filter based on Perangkat
        if ($request->perangkat) {
            $query->where('perangkat', $request->perangkat);
        }

        // Filter based on Date Range
        if ($request->tgl_mulai) {
            $query->whereDate('tanggal_penggantian', '>=', $request->tgl_mulai);
        }
        if ($request->tgl_selesai) {
            $query->whereDate('tanggal_penggantian', '<=', $request->tgl_selesai);
        }

        $data = $query->latest()->get();
        // Fetch sites for "Add" modal search/dropdown
        $sites = Site::all();

        return view('pergantianperangkat', compact('data', 'sites'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'perangkat' => 'required|string',
            'sn_lama' => 'nullable|string',
            'sn_baru' => 'nullable|string',
            'tanggal_penggantian' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $log = LogPerangkat::create($validated);

        // Optional: Update SN in sites table if sn_baru is provided
        if ($log->sn_baru) {
            $site = Site::where('id', $log->site_id)->first();
            
            if ($site) {
                $perangkat = strtoupper($log->perangkat);
                
                if (str_contains($perangkat, 'MODEM')) $site->sn_modem = $log->sn_baru;
                elseif (str_contains($perangkat, 'ROUTER')) $site->sn_router = $log->sn_baru;
                elseif (str_contains($perangkat, 'SWITCH')) $site->sn_switch = $log->sn_baru;
                elseif (str_contains($perangkat, 'AP1')) $site->sn_ap1 = $log->sn_baru;
                elseif (str_contains($perangkat, 'AP2')) $site->sn_ap2 = $log->sn_baru;
                elseif (str_contains($perangkat, 'STAVOL') || str_contains($perangkat, 'STABILIZER')) $site->sn_stabilizer = $log->sn_baru;
                
                $site->save();
            }
        }

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new LogPerangkatImport, $request->file('file'));
            return back()->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new LogPerangkatExport, 'pergantian_perangkat.xlsx');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'perangkat' => 'required|string',
            'sn_lama' => 'nullable|string',
            'sn_baru' => 'nullable|string',
            'tanggal_penggantian' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $log = LogPerangkat::findOrFail($id);
        $log->update($validated);

        // Optional: Update SN in sites table if sn_baru is updated
        if ($log->sn_baru) {
            $site = Site::where('id', $log->site_id)->first();
            if ($site) {
                $perangkat = strtoupper($log->perangkat);
                if (str_contains($perangkat, 'MODEM')) $site->sn_modem = $log->sn_baru;
                elseif (str_contains($perangkat, 'ROUTER')) $site->sn_router = $log->sn_baru;
                elseif (str_contains($perangkat, 'SWITCH')) $site->sn_switch = $log->sn_baru;
                elseif (str_contains($perangkat, 'AP1')) $site->sn_ap1 = $log->sn_baru;
                elseif (str_contains($perangkat, 'AP2')) $site->sn_ap2 = $log->sn_baru;
                elseif (str_contains($perangkat, 'STAVOL') || str_contains($perangkat, 'STABILIZER')) $site->sn_stabilizer = $log->sn_baru;
                $site->save();
            }
        }

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        LogPerangkat::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }
}