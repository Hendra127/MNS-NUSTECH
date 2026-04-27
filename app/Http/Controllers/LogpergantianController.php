<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogPerangkat;

class LogpergantianController extends Controller
{
    public function index(Request $request)
    {
        $query = LogPerangkat::with('site');

        // Search
        if ($request->search) {
            $searchTerm = trim($request->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('perangkat', 'like', "%{$searchTerm}%")
                  ->orWhere('sn_lama', 'like', "%{$searchTerm}%")
                  ->orWhere('sn_baru', 'like', "%{$searchTerm}%")
                  ->orWhere('keterangan', 'like', "%{$searchTerm}%")
                  ->orWhereHas('site', function ($sq) use ($searchTerm) {
                      $sq->where('site_id', 'like', "%{$searchTerm}%")
                         ->orWhere('sitename', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filter by Perangkat
        if ($request->perangkat) {
            $query->where('perangkat', $request->perangkat);
        }

        // Filter by Layanan (if column exists)
        if ($request->layanan) {
            $query->where('layanan', $request->layanan);
        }

        // Date range filter
        if ($request->tgl_mulai) {
            $query->whereDate('tanggal_penggantian', '>=', $request->tgl_mulai);
        }
        if ($request->tgl_selesai) {
            $query->whereDate('tanggal_penggantian', '<=', $request->tgl_selesai);
        }

        $log_data = $query->latest()->paginate(50)->withQueryString();
        $sites = \App\Models\Site::all();

        return view('logpergantian', [
            'log_data' => $log_data,
            'sites' => $sites,
        ]);
    }
}