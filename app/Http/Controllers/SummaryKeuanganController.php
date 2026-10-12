<?php

namespace App\Http\Controllers;

use App\Models\CmPengajuan;
use App\Models\CsrPengajuan;
use App\Models\PengajuanSparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SummaryKeuanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Filter bulan & tahun
        $month = (int) $request->input('month', now()->month);
        $year  = (int) $request->input('year', now()->year);

        // ============================================================
        // 1. PENGAJUAN PERANGKAT (PengajuanSparepart)
        // ============================================================
        $allPengajuan = PengajuanSparepart::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        // Beli Baru
        $beliBaru = $allPengajuan->filter(fn($p) => strtolower($p->tipe_pengajuan ?? '') !== 'repair');
        // Repair
        $repair   = $allPengajuan->filter(fn($p) => strtolower($p->tipe_pengajuan ?? '') === 'repair');

        // Items dari Beli Baru (JSON field 'items')
        $beliBaru_items = collect();
        foreach ($beliBaru as $p) {
            $items = is_array($p->items) ? $p->items : json_decode($p->items, true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    $beliBaru_items->push([
                        'nama'  => $item['nama'] ?? $item['name'] ?? '-',
                        'qty'   => $item['qty'] ?? $item['jumlah'] ?? 1,
                        'harga' => $item['harga'] ?? $item['price'] ?? 0,
                    ]);
                }
            }
        }

        // Items dari Repair
        $repair_items = collect();
        foreach ($repair as $p) {
            $items = is_array($p->items) ? $p->items : json_decode($p->items, true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    $repair_items->push([
                        'nama'  => $item['nama'] ?? $item['name'] ?? '-',
                        'qty'   => $item['qty'] ?? $item['jumlah'] ?? 1,
                        'harga' => $item['harga'] ?? $item['price'] ?? 0,
                    ]);
                }
            }
        }

        $perangkat_total_belibaru = $beliBaru->sum('grand_total');
        $perangkat_total_repair   = $repair->sum('grand_total');
        $perangkat_total          = $perangkat_total_belibaru + $perangkat_total_repair;

        // ============================================================
        // 2. CSR (CsrPengajuan)
        // ============================================================
        $csrAll = CsrPengajuan::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        // Pisahkan berdasar nama_site atau rincian yg mengandung 'BMN'/'SL'
        $csrBmn = $csrAll->filter(function ($csr) {
            $namaSite = strtoupper($csr->nama_site ?? '');
            $rincian  = strtoupper($csr->rincian_kebutuhan ?? '');
            return str_contains($namaSite, 'BMN') || str_contains($rincian, 'BMN');
        });

        $csrSl = $csrAll->filter(function ($csr) {
            $namaSite = strtoupper($csr->nama_site ?? '');
            $rincian  = strtoupper($csr->rincian_kebutuhan ?? '');
            return str_contains($namaSite, 'SL') || str_contains($rincian, 'SL');
        });

        $csrOther = $csrAll->filter(function ($csr) use ($csrBmn, $csrSl) {
            return !$csrBmn->contains('id', $csr->id) && !$csrSl->contains('id', $csr->id);
        });

        $csr_total_bmn   = $csrBmn->sum('total');
        $csr_total_sl    = $csrSl->sum('total');
        $csr_total_other = $csrOther->sum('total');
        $csr_total       = $csrAll->sum('total');

        // ============================================================
        // 3. CM (CmPengajuan)
        // ============================================================
        $cmAll = CmPengajuan::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $cmBmn = $cmAll->where('kategori', 'BMN');
        $cmSl  = $cmAll->where('kategori', 'SL');

        // CM BMN: Total per kabupaten (berdasar nama_site)
        $cmBmn_per_kabupaten = $cmBmn->groupBy(function ($cm) {
            $site = $cm->nama_site ?? '';
            if (preg_match('/Kab[\.\s]+([^-\n,]+)/i', $site, $m)) {
                return 'Kab. ' . trim($m[1]);
            }
            $parts = explode('-', $site);
            return trim($parts[0]) ?: 'Lainnya';
        })->map(function ($group, $kabupaten) {
            return [
                'kabupaten' => $kabupaten,
                'total'     => $group->sum('total'),
                'count'     => $group->count(),
                'sites'     => $group->pluck('nama_site')->filter()->values(),
            ];
        })->values();

        $cmSl_per_kabupaten = $cmSl->groupBy(function ($cm) {
            $site = $cm->nama_site ?? '';
            if (preg_match('/Kab[\.\s]+([^-\n,]+)/i', $site, $m)) {
                return 'Kab. ' . trim($m[1]);
            }
            $parts = explode('-', $site);
            return trim($parts[0]) ?: 'Lainnya';
        })->map(function ($group, $kabupaten) {
            return [
                'kabupaten' => $kabupaten,
                'total'     => $group->sum('total'),
                'count'     => $group->count(),
                'sites'     => $group->pluck('nama_site')->filter()->values(),
            ];
        })->values();

        $cmAllSites    = $cmAll->pluck('nama_site')->filter()->unique()->values();
        $cm_total_bmn  = $cmBmn->sum('total');
        $cm_total_sl   = $cmSl->sum('total');
        $cm_total      = $cmAll->sum('total');

        // ============================================================
        // CHART DATA: 12 bulan terakhir
        // ============================================================
        $chartMonths = [];
        $chartLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $d = Carbon::create($year, $month, 1)->subMonths($i);
            $chartMonths[] = ['month' => $d->month, 'year' => $d->year];
            $chartLabels[] = $d->locale('id')->isoFormat('MMM YY');
        }

        $chartPengajuan = [];
        $chartCsr       = [];
        $chartCm        = [];
        $chartCmBmn     = [];
        $chartCmSl      = [];

        foreach ($chartMonths as $cd) {
            $chartPengajuan[] = (int) PengajuanSparepart::whereMonth('created_at', $cd['month'])
                ->whereYear('created_at', $cd['year'])
                ->sum('grand_total');

            $chartCsr[] = (int) CsrPengajuan::whereMonth('created_at', $cd['month'])
                ->whereYear('created_at', $cd['year'])
                ->sum('total');

            $chartCm[] = (int) CmPengajuan::whereMonth('created_at', $cd['month'])
                ->whereYear('created_at', $cd['year'])
                ->sum('total');

            $chartCmBmn[] = (int) CmPengajuan::whereMonth('created_at', $cd['month'])
                ->whereYear('created_at', $cd['year'])
                ->where('kategori', 'BMN')
                ->sum('total');

            $chartCmSl[] = (int) CmPengajuan::whereMonth('created_at', $cd['month'])
                ->whereYear('created_at', $cd['year'])
                ->where('kategori', 'SL')
                ->sum('total');
        }

        // Grand Total bulan ini
        $grandTotal = $perangkat_total + $csr_total + $cm_total;

        // List tahun untuk filter
        $years = collect(range(now()->year, now()->year - 3))->values();

        return view('summary_keuangan', compact(
            'month', 'year', 'years',
            'beliBaru', 'repair', 'beliBaru_items', 'repair_items',
            'perangkat_total_belibaru', 'perangkat_total_repair', 'perangkat_total',
            'csrAll', 'csrBmn', 'csrSl', 'csrOther',
            'csr_total_bmn', 'csr_total_sl', 'csr_total_other', 'csr_total',
            'cmAll', 'cmBmn', 'cmSl',
            'cmBmn_per_kabupaten', 'cmSl_per_kabupaten', 'cmAllSites',
            'cm_total_bmn', 'cm_total_sl', 'cm_total',
            'grandTotal',
            'chartLabels', 'chartPengajuan', 'chartCsr', 'chartCm', 'chartCmBmn', 'chartCmSl'
        ));
    }
}
