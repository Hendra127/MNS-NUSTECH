<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Illuminate\Support\Facades\DB;

class DetailticketController extends Controller
{
    public function index(Request $request) {
        $query = Ticket::query();
        $month = $request->month; // Format YYYY-MM
        $kategori = $request->kategori;

        // Fetch all sites for the map
        $allSites = Site::select('site_id', 'site_code', 'sitename', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // Apply Month Filter if exists
        if ($month) {
            $query->whereRaw("DATE_FORMAT(tanggal_rekap, '%Y-%m') = ?", [$month]);
        }

        // Apply Category Filter if exists
        if ($kategori) {
            if ($kategori === 'SL') {
                $query->whereIn('kategori', ['SL', 'SEWA LAYANAN']);
            } elseif ($kategori === 'BMN') {
                $query->where('kategori', 'BARANG MILIK NEGARA (BMN)');
            }
        }

        // 1. LIST OPEN TICKET
        $openTickets = (clone $query)->where('status', 'open')
            ->latest('tanggal_rekap')
            ->take(20)
            ->get();

        // 2. CHART LINE: OPEN & CLOSED TREND
        $dateFormat = $month ? '%Y-%m-%d' : '%Y-%m';
        
        $openTrendRaw = (clone $query)->selectRaw("DATE_FORMAT(tanggal_rekap, '$dateFormat') as ym, COUNT(*) as total")
            ->where('status', 'open')
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        $closedTrendRaw = (clone $query)->selectRaw("DATE_FORMAT(tanggal_rekap, '$dateFormat') as ym, COUNT(*) as total")
            ->where('status', 'closed')
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        // Synchronize labels (merge all dates from both statuses)
        $allLabels = collect($openTrendRaw->pluck('ym'))
            ->merge($closedTrendRaw->pluck('ym'))
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        // Map values to synchronized labels
        $openTrendMap = $openTrendRaw->pluck('total', 'ym');
        $closedTrendMap = $closedTrendRaw->pluck('total', 'ym');

        $openTotals = array_map(fn($l) => $openTrendMap[$l] ?? 0, $allLabels);
        $closedTotals = array_map(fn($l) => $closedTrendMap[$l] ?? 0, $allLabels);

        $trendLabels = $allLabels;

        // 3. BAR: OPEN PER KABUPATEN
        $openByKabRaw = (clone $query)->selectRaw("kabupaten, COUNT(*) as total")
            ->where('status', 'open')
            ->groupBy('kabupaten')
            ->orderByDesc('total')
            ->limit(12)
            ->get();

        $kabLabels = $openByKabRaw->pluck('kabupaten')->toArray();
        $kabTotals = $openByKabRaw->pluck('total')->toArray();

        // 4. CATEGORY DISTRIBUTION (Only Open)
        $byCategoryRaw = (clone $query)->selectRaw("kategori, COUNT(*) as total")
            ->where('status', 'open')
            ->groupBy('kategori')
            ->get();
        
        $catLabels = $byCategoryRaw->pluck('kategori')->toArray();
        $catTotals = $byCategoryRaw->pluck('total')->toArray();

        // 5. ADDITIONAL KPI & INSIGHTS
        $totalTickets = (clone $query)->count();
        $closedCount = (clone $query)->where('status', 'closed')->count();
        $resolvedRate = $totalTickets > 0 ? round(($closedCount / $totalTickets) * 100, 1) : 0;
        
        $avgResTime = (clone $query)->where('status', 'closed')->avg('durasi');
        $avgResTime = $avgResTime ? round($avgResTime, 1) : 0;

        $topProblemRow = (clone $query)->selectRaw("kendala, COUNT(*) as total")
            ->whereNotNull('kendala')
            ->groupBy('kendala')
            ->orderByDesc('total')
            ->first();
        $topProblem = $topProblemRow ? $topProblemRow->kendala : 'None';

        $totalSitesCount = Site::count();

        if ($request->ajax()) {
            return response()->json([
                'openTickets' => $openTickets,
                'trendLabels' => $trendLabels,
                'openTotals' => $openTotals,
                'closedTotals' => $closedTotals,
                'kabLabels' => $kabLabels,
                'kabTotals' => $kabTotals,
                'catLabels' => $catLabels,
                'catTotals' => $catTotals,
                'resolvedRate' => $resolvedRate,
                'avgResTime' => $avgResTime,
                'topProblem' => $topProblem,
                'totalTickets' => $totalTickets
            ]);
        }

        return view('detailticket', compact(
            'openTickets', 'trendLabels', 'openTotals', 'closedTotals', 'kabLabels', 'kabTotals', 
            'catLabels', 'catTotals', 'allSites', 'resolvedRate', 'avgResTime', 'topProblem', 
            'totalTickets', 'totalSitesCount'
        ));
    }
}
