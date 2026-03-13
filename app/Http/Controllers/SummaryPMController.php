<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SitePM; // Pastikan model Anda sesuai
use Illuminate\Support\Facades\DB;
use App\Models\PMLiberta; // Pastikan model Anda sesuai
class SummaryPMController extends Controller
{
    public function index(Request $request)
    {
        // Get selected month and year from request, or default to current month/year
        $selectedBulan = $request->input('bulan', now()->month);
        $selectedTahun = $request->input('tahun', now()->year);

        // 1. Data untuk Counter Box (BMN, SL, Total) - Handle variasi penulisan kategori
        $bmnCount = PMLiberta::where(function($q) {
            $q->where('kategori', 'LIKE', '%BMN%')
              ->orWhere('kategori', 'LIKE', '%BARANG MILIK NEGARA%');
        })->where('status', 'DONE')->count();

        $slCount = PMLiberta::where(function($q) {
            $q->where('kategori', 'LIKE', '%SL%')
              ->orWhere('kategori', 'LIKE', '%SEWA LAYANAN%');
        })->where('status', 'DONE')->count();
        $totalCount = $bmnCount + $slCount;

        // 2. Data untuk Chart (Total Done per Tanggal di bulan berjalan)
        // Mengambil data jumlah 'DONE' per hari
        $chartData = PMLiberta::select(DB::raw('DATE(date) as date'), DB::raw('count(*) as total'))
            ->where('status', 'DONE')
            ->whereMonth('date', $selectedBulan)
            ->whereYear('date', $selectedTahun)
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // 3. Data untuk Tabel Summary per Bulan - Handle variasi kategori
        $monthlySummary = PMLiberta::select(
                'month',
                DB::raw("SUM(CASE WHEN kategori LIKE '%BMN%' OR UPPER(kategori) LIKE '%BARANG MILIK NEGARA%' THEN 1 ELSE 0 END) as bmn_total"),
                DB::raw("SUM(CASE WHEN kategori LIKE '%SL%' OR UPPER(kategori) LIKE '%SEWA LAYANAN%' THEN 1 ELSE 0 END) as sl_total")
            )
            ->where('status', 'DONE')
            ->groupBy('month')
            ->get();

        // 4. Data untuk List Site PM (dengan Fitur Search & Pagination)
        // Hanya menampilkan data dengan status DONE
        $query = PMLiberta::where('status', 'DONE');

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lokasi', 'like', '%' . $request->search . '%')
                  ->orWhere('site_id', 'like', '%' . $request->search . '%');
            });
        }

        $sites = $query->limit(20)->get(); // Menampilkan maksimal 20 data dalam bentuk card

        // 5. Data untuk Chart Kondisi Perangkat (Baik vs Rusak)
        $countBaik  = \App\Models\Sparetracker::where('kondisi', 'BAIK')->count();
        $countRusak = \App\Models\Sparetracker::where('kondisi', 'RUSAK')->count();

        return view('summarypm', compact(
            'bmnCount',     
            'slCount', 
            'totalCount', 
            'chartData', 
            'monthlySummary', 
            'sites',
            'countBaik',
            'countRusak',
            'selectedBulan', // Pass selected month to the view
            'selectedTahun'  // Pass selected year to the view
        ));
    }

    /**
     * Get chart data for AJAX calls based on month/year or date range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChartData(Request $request)
    {
        $query = PMLiberta::select(DB::raw('DATE(date) as date'), DB::raw('count(*) as total'))
            ->where('status', 'DONE');

        // Filter by month and year if provided
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('date', $request->bulan)
                  ->whereYear('date', $request->tahun);
        } 
        // Filter by date range if provided
        elseif ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } else {
            // Default to current month if no filters are provided
            $query->whereMonth('date', now()->month)
                  ->whereYear('date', now()->year);
        }

        $chartData = $query->groupBy('date')
                           ->orderBy('date', 'ASC')
                           ->get();

        return response()->json($chartData);
    }

    /**
     * Get filtered sites list for AJAX calls (same filter as chart).
     */
    public function getSites(Request $request)
    {
        $query = PMLiberta::where('status', 'DONE');

        // Filter by month and year
        if ($request->has('bulan') && $request->has('tahun')) {
            $query->whereMonth('date', $request->bulan)
                  ->whereYear('date', $request->tahun);
        }
        // Filter by date range
        elseif ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } else {
            // Default: current month
            $query->whereMonth('date', now()->month)
                  ->whereYear('date', now()->year);
        }

        $sites = $query->orderBy('date', 'DESC')->limit(20)->get([
            'site_id', 'nama_lokasi', 'kabupaten', 'kategori', 'status', 'month', 'date'
        ]);

        return response()->json($sites);
    }
}