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
        $sparetrackers = Sparetracker::where('status_penggunaan_sparepart', 'Stok')->get();
        return view('pengiriman', compact('sites', 'pengirimans', 'sparetrackers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekspedisi' => 'required|string|max:255',
            'no_resi' => 'required|string|max:255',
            'sn_perangkat' => 'required|string|max:255',
            'site_id' => 'required|exists:sites,site_id',
            'keterangan' => 'nullable|string',
            'tanggal_pengiriman' => 'nullable|date',
            'nama_pengirim' => 'nullable|string|max:255',
            'nama_penerima' => 'nullable|string|max:255',
            'kabkota_pengirim' => 'nullable|string|max:255',
            'kabkota_penerima' => 'nullable|string|max:255',
            'biaya_pengiriman' => 'nullable|numeric',
            'klasifikasi' => 'nullable|string|in:BMN,SL',
        ]);

        $snInput = trim($request->sn_perangkat);

        $pengiriman = Pengiriman::create([
            'ekspedisi' => $request->ekspedisi,
            'no_resi' => $request->no_resi,
            'sn_perangkat' => $snInput,
            'site_id' => $request->site_id,
            'status' => 'Dalam Pengiriman',
            'keterangan' => $request->keterangan,
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'nama_pengirim' => $request->nama_pengirim,
            'nama_penerima' => $request->nama_penerima,
            'kabkota_pengirim' => $request->kabkota_pengirim,
            'kabkota_penerima' => $request->kabkota_penerima,
            'biaya_pengiriman' => $request->biaya_pengiriman,
            'klasifikasi' => $request->klasifikasi ?? 'BMN',
        ]);

        // Logic update Sparetracker — cari dengan trim dan case insensitive
        $site = Site::where('site_id', $request->site_id)->first();
        $tracker = Sparetracker::whereRaw('TRIM(LOWER(sn)) = ?', [strtolower($snInput)])->first();

        if ($tracker && $site) {
            $statusLama = $tracker->status_penggunaan_sparepart;
            $kondisiLama = $tracker->kondisi;

            $tracker->update([
                'status_penggunaan_sparepart' => 'Dikirim ke Site',
                'tanggal_keluar' => now(),
            ]);

            LogPergantian::create([
                'sn_perangkat' => $snInput,
                'aksi' => 'dikirim',
                'keterangan' => 'Perangkat dikirim ke site ' . ($site->sitename ?? '-') . ' via ' . $request->ekspedisi . ' (Resi: ' . $request->no_resi . ')',
                'status_lama' => $statusLama,
                'status_baru' => 'Dikirim ke Site',
                'kondisi_lama' => $kondisiLama,
                'kondisi_baru' => $kondisiLama,
                'user_id' => Auth::id() ?? 1,
            ]);

            return redirect()->back()->with('success', 'Data pengiriman berhasil disimpan! Sparetracker (SN: ' . $snInput . ') diupdate ke status "Dikirim ke Site".');
        } elseif (!$tracker) {
            // SN tidak ditemukan di Sparetracker — data pengiriman tetap tersimpan
            return redirect()->back()->with('error', 'Data pengiriman tersimpan, tapi SN "' . $snInput . '" tidak ditemukan di Sparetracker. Pastikan SN sudah terdaftar di halaman Spare Tracker.');
        } else {
            return redirect()->back()->with('success', 'Data pengiriman berhasil disimpan.');
        }
    }

    public function terima($id)
    {
        $pengiriman = Pengiriman::findOrFail($id);

        if ($pengiriman->status === 'Diterima') {
            return redirect()->back()->with('error', 'Status pengiriman sudah Diterima.');
        }

        $pengiriman->update(['status' => 'Diterima']);

        $snInput = trim($pengiriman->sn_perangkat);
        $site = Site::where('site_id', $pengiriman->site_id)->first();
        $tracker = Sparetracker::whereRaw('TRIM(LOWER(sn)) = ?', [strtolower($snInput)])->first();

        if ($tracker && $site) {
            $statusLama = $tracker->status_penggunaan_sparepart;
            $kondisiLama = $tracker->kondisi;

            $tracker->update([
                'status_penggunaan_sparepart' => 'Terpasang',
                'lokasi_realtime' => $site->sitename,
                'lokasi' => $site->site_id,
                'kabupaten' => $site->kab,
            ]);

            LogPergantian::create([
                'sn_perangkat' => $snInput,
                'aksi' => 'diterima',
                'keterangan' => 'Perangkat telah diterima di site ' . ($site->sitename ?? '-'),
                'status_lama' => $statusLama,
                'status_baru' => 'Terpasang',
                'kondisi_lama' => $kondisiLama,
                'kondisi_baru' => $kondisiLama,
                'user_id' => Auth::id() ?? 1,
            ]);

            return redirect()->back()->with('success', 'Pengiriman Diterima! Sparetracker (SN: ' . $snInput . ') lokasi diperbarui ke ' . ($site->sitename ?? '-') . '.');
        } elseif (!$tracker) {
            return redirect()->back()->with('error', 'Status pengiriman berhasil diubah ke Diterima, tapi SN "' . $snInput . '" tidak ditemukan di Sparetracker. Update lokasi gagal dilakukan.');
        } else {
            return redirect()->back()->with('success', 'Pengiriman telah Diterima.');
        }
    }
}
