<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RemoteLog;
use Carbon\Carbon;

class RemoteLogController extends Controller
{
    /**
     * Tampilkan halaman log remote
     */
    public function index(Request $request)
    {
        $query = RemoteLog::with('user')->latest();

        // Filter by search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('site_name', 'like', "%{$search}%")
                  ->orWhere('site_code', 'like', "%{$search}%")
                  ->orWhere('ip_router', 'like', "%{$search}%")
                  ->orWhere('tunnel_name', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->tgl_mulai) {
            $query->whereDate('created_at', '>=', $request->tgl_mulai);
        }
        if ($request->tgl_selesai) {
            $query->whereDate('created_at', '<=', $request->tgl_selesai);
        }

        $logs = $query->paginate(25)->withQueryString();

        // Stats
        $totalToday = RemoteLog::whereDate('created_at', Carbon::today())->count();
        $totalWeek = RemoteLog::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $totalAll = RemoteLog::count();

        return view('remotelog', compact('logs', 'totalToday', 'totalWeek', 'totalAll'));
    }

    /**
     * Catat log remote baru (dipanggil via AJAX dari JS)
     */
    public function store(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string',
            'ip_router' => 'required|string',
            'tunnel_name' => 'required|string',
        ]);

        $log = RemoteLog::create([
            'user_id'     => auth()->id(),
            'user_name'   => auth()->user()->name ?? 'Unknown',
            'site_name'   => $request->site_name,
            'site_code'   => $request->site_code,
            'ip_router'   => $request->ip_router,
            'tunnel_name' => $request->tunnel_name,
            'source_page' => $request->source_page ?? 'unknown',
            'status'      => $request->status ?? 'unknown',
        ]);

        return response()->json(['success' => true, 'log' => $log]);
    }
}
