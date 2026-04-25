<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PMLiberta;
use App\Models\User;
use App\Notifications\StatusHoldNotification;
use App\Exports\PMLibertaExport;
use App\Imports\PMLibertaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;

class PMLibertaController extends Controller
{
    public function index(Request $request)
    {
        $sites = \App\Models\Site::orderBy('site_id', 'asc')->get();

        // Ambil data unik Provinsi dan Kabupaten untuk cascading filter
        $category = $request->kategori;
        $provinsiListQuery = \App\Models\Site::query();
        if ($category) {
            // Mapping Kategori PM ke Tipe Site di database
            // Jika Kategori PM 'BMN' -> cari Tipe Site 'BARANG MILIK NEGARA'
            // Jika Kategori PM 'SL' -> cari Tipe Site 'SEWA LAYANAN'
            $tipeSearch = ($category === 'BMN') ? 'BARANG MILIK NEGARA' : 'SEWA LAYANAN';
            $provinsiListQuery->where('tipe', 'LIKE', '%' . $tipeSearch . '%');
        }

        $provinsiList = $provinsiListQuery->whereNotNull('provinsi')
            ->where('provinsi', '!=', '')
            ->distinct()
            ->orderBy('provinsi', 'asc')
            ->pluck('provinsi');

        $provinsiKabMap = [];
        foreach ($provinsiList as $p) {
            $kabQuery = \App\Models\Site::where('provinsi', $p)
                ->whereNotNull('kab')
                ->where('kab', '!=', '');

            if ($category) {
                $tipeSearch = ($category === 'BMN') ? 'BARANG MILIK NEGARA' : 'SEWA LAYANAN';
                $kabQuery->where('tipe', 'LIKE', '%' . $tipeSearch . '%');
            }

            $provinsiKabMap[$p] = $kabQuery->distinct()->orderBy('kab', 'asc')->pluck('kab');
        }

        $query = PMLiberta::query();

        // 1. Filter Search Box (Nama Lokasi, Site ID, atau PIC CE)
        $searchTerm = $request->search ?? $request->q;
        $query->when($searchTerm, function ($q) use ($searchTerm) {
            return $q->where(function ($sub) use ($searchTerm) {
                $sub->where('nama_lokasi', 'like', '%' . $searchTerm . '%')
                    ->orWhere('site_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('pic_ce', 'like', '%' . $searchTerm . '%');
            });
        });


        // 2. Filter Kategori
        $query->when($request->kategori, function ($q) use ($request) {
            return $q->where('kategori', $request->kategori);
        });

        // [MOD] Filter Provinsi & Kabupaten
        $query->when($request->provinsi, function ($q) use ($request) {
            return $q->where('provinsi', $request->provinsi);
        });
        $query->when($request->kab, function ($q) use ($request) {
            return $q->where('kabupaten', $request->kab);
        });

        // 3. Filter Status
        $query->when($request->status, function ($q) use ($request) {
            if ($request->status === 'PENDING') {
                return $q->where(function ($sub) {
                    $sub->where('status', 'PENDING')
                        ->orWhereNull('status')
                        ->orWhere('status', '');
                });
            }
            return $q->where('status', $request->status);
        });

        // 4. Filter Rentang Tanggal
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('date', [$request->tgl_mulai, $request->tgl_selesai]);
        } elseif ($request->tgl_mulai) {
            $query->where('date', '>=', $request->tgl_mulai);
        } elseif ($request->tgl_selesai) {
            $query->where('date', '<=', $request->tgl_selesai);
        }

        // Hitung Statistik untuk Pill Badges
        $totalBMNDone = (clone $query)->where('kategori', 'BMN')->where('status', 'DONE')->count();
        $totalSLDone = (clone $query)->where('kategori', 'SL')->where('status', 'DONE')->count();
        $totalHold = (clone $query)->where('status', 'HOLD')->count();
        $totalPending = (clone $query)->where(function ($q) {
            $q->where('status', 'PENDING')
                ->orWhereNull('status')
                ->orWhere('status', '');
        })->count();

        // Ambil data dan pertahankan filter saat pindah halaman
        $pm_data = $query->orderBy('date', 'desc')->paginate(50)->withQueryString();

        return view('PMLiberta', [
            'pm_data' => $pm_data,
            'totalBMNDone' => $totalBMNDone,
            'totalSLDone' => $totalSLDone,
            'totalHold' => $totalHold,
            'totalPending' => $totalPending,
            'sites' => $sites,
            'provinsiList' => $provinsiList,
            'provinsiKabMap' => $provinsiKabMap
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_id' => 'required',
            'nama_lokasi' => 'required',
            'kategori' => 'required',
            'status' => 'required',
        ]);

        // Cek apakah data sudah ada (Site ID + Tanggal + Kategori)
        $existing = PMLiberta::where('site_id', $request->site_id)
            ->where('date', $request->date)
            ->where('kategori', $request->kategori)
            ->first();

        if ($existing) {
            return back()->with('error', "Data untuk Site {$request->site_id} pada tanggal {$request->date} ({$request->kategori}) sudah ada dengan status: {$existing->status}");
        }

        // [MOD] Restriction for role 'admin'
        if (auth()->user()->role === 'admin' && strtoupper($request->status) === 'DONE') {
            return back()->with('error', 'Role Admin tidak diperbolehkan mengatur status ke DONE.');
        }

        PMLiberta::create([
            'site_id' => $request->site_id,
            'nama_lokasi' => $request->nama_lokasi,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'date' => $request->date,
            'month' => $request->month,
            'status' => $request->status,
            'week' => $request->week,
            'kategori' => $request->kategori,
            'pic_ce' => $request->pic_ce,
            'file_pm' => $request->file_pm,
        ]);

        // [MOD] Notification if status is HOLD
        if (strtoupper($request->status) === 'HOLD' && auth()->user()->role === 'admin') {
            $recipients = User::where('role', 'superadmin')->get();
            Notification::send($recipients, new StatusHoldNotification((object) $request->all(), auth()->user()));
        }

        return back()->with('success', 'Data berhasil ditambahkan!');
    }
    public function export(Request $request)
    {
        $search = $request->input('search');
        return Excel::download(new PMLibertaExport($search), 'PM_Liberta_Report.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new PMLibertaImport, $request->file('file'));
            return back()->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $data = PMLiberta::findOrFail($id);

        // [MOD] Restriction for role 'admin'
        if (auth()->user()->role === 'admin') {
            if (strtoupper($request->status) === 'DONE') {
                return back()->with('error', 'Role Admin tidak diperbolehkan mengatur status ke DONE.');
            }
            if (strtoupper($data->status) === 'DONE') {
                return back()->with('error', 'Data yang sudah DONE tidak dapat diubah oleh Admin.');
            }
        }

        $oldStatus = $data->status;

        $data->update([
            'site_id' => $request->site_id,
            'nama_lokasi' => $request->nama_lokasi,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'date' => $request->date,
            'month' => $request->month,
            'status' => $request->status,
            'week' => $request->week,
            'kategori' => $request->kategori,
            'file_pm' => $request->file_pm,
        ]);

        // [MOD] Notification if status is changed to HOLD by admin
        if (strtoupper($request->status) === 'HOLD' && auth()->user()->role === 'admin') {
            $recipients = User::where('role', 'superadmin')->get();
            Notification::send($recipients, new StatusHoldNotification($data, auth()->user()));
        }

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = PMLiberta::findOrFail($id);

        // [MOD] Restriction for role 'admin': Cannot delete records that are already DONE
        if (auth()->check() && auth()->user()->role === 'admin' && strtoupper($data->status) === 'DONE') {
            return back()->with('error', 'Data yang sudah DONE tidak dapat dihapus oleh Admin.');
        }

        $data->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}