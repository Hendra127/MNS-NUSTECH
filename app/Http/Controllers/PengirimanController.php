<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\Sparetracker;
use App\Models\Site;
use App\Models\LogPergantian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengirimanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sites = Site::orderBy('sitename')->get();
        $pengirimans = Pengiriman::with('site')->latest()->paginate(20);
        // Show all sparetrackers with SN for dropdown (not just Stok, in case SN needs to be tracked)
        $sparetrackers = Sparetracker::whereNotNull('sn')->orderBy('sn')->get();
        return view('pengiriman', compact('sites', 'pengirimans', 'sparetrackers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekspedisi'          => 'required|string|max:255',
            'no_resi'            => 'required|string|max:255',
            'sn_perangkat'       => 'required|string|max:255',
            'site_id'            => 'required|string|max:255',
            'keterangan'         => 'nullable|string',
            'tanggal_pengiriman' => 'nullable|date',
            'nama_pengirim'      => 'nullable|string|max:255',
            'nama_penerima'      => 'nullable|string|max:255',
            'kabkota_pengirim'   => 'nullable|string|max:255',
            'kabkota_penerima'   => 'nullable|string|max:255',
            'biaya_pengiriman'   => 'nullable|numeric',
            'klasifikasi'        => 'nullable|string|in:BMN,SL',
        ]);

        $snInput = trim($request->sn_perangkat);

        // Store pengiriman record first (always)
        Pengiriman::create([
            'ekspedisi'          => $request->ekspedisi,
            'no_resi'            => $request->no_resi,
            'sn_perangkat'       => $snInput,
            'site_id'            => $request->site_id,
            'status'             => 'Dalam Pengiriman',
            'keterangan'         => $request->keterangan,
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'nama_pengirim'      => $request->nama_pengirim,
            'nama_penerima'      => $request->nama_penerima,
            'kabkota_pengirim'   => $request->kabkota_pengirim,
            'kabkota_penerima'   => $request->kabkota_penerima,
            'biaya_pengiriman'   => $request->biaya_pengiriman,
            'klasifikasi'        => $request->klasifikasi ?? 'BMN',
        ]);

        // Try to find matching site (may be manual input, not in DB)
        $site = Site::where('site_id', $request->site_id)->first();
        $siteName = $site ? $site->sitename : $request->site_id;

        // Try to find sparetracker by SN (case-insensitive, trimmed)
        $tracker = Sparetracker::whereRaw('TRIM(LOWER(sn)) = LOWER(TRIM(?))', [$snInput])->first();

        if ($tracker) {
            $statusLama  = $tracker->status_penggunaan_sparepart;
            $kondisiLama = $tracker->kondisi;

            $tracker->update([
                'lokasi_asal'                 => $tracker->lokasi_realtime,
                'status_penggunaan_sparepart' => 'Dikirim ke Site',
                'tanggal_keluar'              => now(),
                'keterangan'                  => 'TELAH DIKIRIM KE LOKASI ' . strtoupper($siteName) . ', MENUNGGU PEMASANGAN',
            ]);

            LogPergantian::create([
                'sn_perangkat' => $snInput,
                'aksi'         => 'dikirim',
                'keterangan'   => 'Perangkat dikirim ke ' . $siteName . ' via ' . $request->ekspedisi . ' (Resi: ' . $request->no_resi . ')',
                'status_lama'  => $statusLama,
                'status_baru'  => 'Dikirim ke Site',
                'kondisi_lama' => $kondisiLama,
                'kondisi_baru' => $kondisiLama,
                'user_id'      => Auth::id() ?? 1,
            ]);
        }

        return redirect()->back()->with('success', 'Data pengiriman berhasil disimpan!' . ($tracker ? ' Spare Tracker SN ' . $snInput . ' diupdate.' : ''));
    }

    public function terima($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        if ($pengiriman->status === 'Diterima') {
            return redirect()->back()->with('error', 'Status pengiriman sudah Diterima.');
        }

        $pengiriman->update(['status' => 'Diterima']);

        $snInput  = trim($pengiriman->sn_perangkat);
        $site     = Site::where('site_id', $pengiriman->site_id)->first();
        $siteName = $site ? $site->sitename : $pengiriman->site_id;

        // Find sparetracker - case insensitive, trimmed
        $tracker = Sparetracker::whereRaw('TRIM(LOWER(sn)) = LOWER(TRIM(?))', [$snInput])->first();

        if ($tracker) {
            $statusLama  = $tracker->status_penggunaan_sparepart;
            $kondisiLama = $tracker->kondisi;

            $isManualSite = !$site;
            $statusBaru = $isManualSite ? 'Spare' : 'Terpasang';
            $keteranganBaru = $isManualSite ? 'TERSEDIA SEBAGAI SPARE DI ' . strtoupper($siteName) : 'Terpasang di ' . strtoupper($siteName);

            $tracker->update([
                'status_penggunaan_sparepart' => $statusBaru,
                'lokasi_realtime'             => $siteName,
                'lokasi'                      => $site ? $site->site_id : $pengiriman->site_id,
                'kabupaten'                   => $site ? $site->kab : null,
                'keterangan'                  => $keteranganBaru,
                'tanggal_keluar'              => $tracker->tanggal_keluar ?? now(),
            ]);

            LogPergantian::create([
                'sn_perangkat' => $snInput,
                'aksi'         => 'diterima',
                'keterangan'   => 'Perangkat diterima ' . ($isManualSite ? 'sebagai Spare di ' : 'dan terpasang di site ') . $siteName,
                'status_lama'  => $statusLama,
                'status_baru'  => $statusBaru,
                'kondisi_lama' => $kondisiLama,
                'kondisi_baru' => $kondisiLama,
                'user_id'      => Auth::id() ?? 1,
            ]);

            return redirect()->back()->with('success', 'Pengiriman Diterima! Spare Tracker SN ' . $snInput . ' lokasi diperbarui ke ' . $siteName . '.');
        }

        return redirect()->back()->with('success', 'Pengiriman berhasil ditandai Diterima. (SN "' . $snInput . '" tidak ditemukan di Spare Tracker, update lokasi dilewati.)');
    }
}

