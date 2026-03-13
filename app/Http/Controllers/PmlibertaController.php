<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PMLiberta;
use App\Exports\PMLibertaExport;
use App\Imports\PMLibertaImport;
use Maatwebsite\Excel\Facades\Excel;

class PMLibertaController extends Controller
{
    public function index(Request $request)
    {
        $sites = \App\Models\Site::orderBy('site_id', 'asc')->get();
        $query = PMLiberta::query();

        // 1. Filter Search Box (Nama Lokasi atau Site ID)
        $query->when($request->q, function ($q) use ($request) {
            return $q->where(function ($sub) use ($request) {
                    $sub->where('nama_lokasi', 'like', '%' . $request->q . '%')
                        ->orWhere('site_id', 'like', '%' . $request->q . '%');
                }
                );
            });

        // 2. Filter Kategori
        $query->when($request->kategori, function ($q) use ($request) {
            return $q->where('kategori', $request->kategori);
        });

        // 3. Filter Status
        $query->when($request->status, function ($q) use ($request) {
            return $q->where('status', $request->status);
        });

        // 4. Filter Rentang Tanggal
        if ($request->tgl_mulai && $request->tgl_selesai) {
            $query->whereBetween('date', [$request->tgl_mulai, $request->tgl_selesai]);
        }
        elseif ($request->tgl_mulai) {
            $query->where('date', '>=', $request->tgl_mulai);
        }
        elseif ($request->tgl_selesai) {
            $query->where('date', '<=', $request->tgl_selesai);
        }

        // Hitung Statistik untuk Pill Badges
        $totalBMNDone = (clone $query)->where('kategori', 'BMN')->where('status', 'DONE')->count();
        $totalSLDone = (clone $query)->where('kategori', 'SL')->where('status', 'DONE')->count();
        $totalPending = (clone $query)->where('status', 'PENDING')->count();

        // Ambil data dan pertahankan filter saat pindah halaman
        $data = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();

        return view('PMLiberta', compact('data', 'totalBMNDone', 'totalSLDone', 'totalPending', 'sites'));
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
        ]);

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
        }
        catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $data = PMLiberta::findOrFail($id);

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
            // Tambahkan kolom lain sesuai kebutuhan
        ]);

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = PMLiberta::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus!');
    }
}