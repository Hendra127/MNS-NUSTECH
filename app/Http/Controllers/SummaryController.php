<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;

use App\Models\Sparetracker;
use Illuminate\Support\Facades\DB;

class SummaryController extends Controller
{
    public function index()
    {
        // Ambil data stok per jenis dan kondisi
        $stats = Sparetracker::select('jenis', 
            DB::raw("SUM(CASE WHEN kondisi = 'BAIK' THEN 1 ELSE 0 END) as baik"),
            DB::raw("SUM(CASE WHEN kondisi = 'RUSAK' THEN 1 ELSE 0 END) as rusak"),
            DB::raw("SUM(CASE WHEN kondisi = 'BARU' THEN 1 ELSE 0 END) as baru")
        )
        ->groupBy('jenis')
        ->get();

        // Hitung Grand Total Keseluruhan
        $totalBaik = $stats->sum('baik');
        $totalRusak = $stats->sum('rusak');
        $totalBaru = $stats->sum('baru');
        $grandTotal = $totalBaik + $totalRusak + $totalBaru;

        // --- Data Summary Pergantian Perangkat ---
        // Jumlah pergantian per jenis perangkat
        $replacementStats = \App\Models\LogPerangkat::select('perangkat', DB::raw('count(*) as total'))
            ->groupBy('perangkat')
            ->get();

        // Data histori pergantian (Device, Site, Tanggal)
        $replacementLogs = \App\Models\LogPerangkat::with('site')
            ->latest('tanggal_penggantian')
            ->take(10) // Tampilkan 10 terakhir saja untuk ringkasan
            ->get();

        return view('summaryperangkat', compact(
            'stats', 
            'totalBaik', 
            'totalRusak', 
            'totalBaru', 
            'grandTotal',
            'replacementStats',
            'replacementLogs'
        ));
    }
}