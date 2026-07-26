<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparepartNeeded;
use App\Models\Sparetracker;
use App\Models\Pengiriman;
use App\Models\Site;
use App\Models\LogPergantian;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * LOGIKA 1: Halaman Sparepart Needed (Pengajuan Baru)
     */
    public function storeSparepart(Request $request)
    {
        $request->validate([
            'tipe_pengajuan' => 'required|in:Pembelian Baru,Repair Perangkat',
            'perangkat' => 'required|array',
            'perangkat.*' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $perangkatList = $request->perangkat;
            $qtyList = $request->input('qty', []);
            $hargaList = $request->input('harga', []);
            $keteranganList = $request->input('keterangan', []);
            $snList = $request->input('sn_perangkat', []);

            foreach ($perangkatList as $index => $nama_perangkat) {
                // Determine SN (fallback to random if totally empty and pembelian baru, though repair requires it)
                $sn = isset($snList[$index]) && !empty($snList[$index]) ? $snList[$index] : 'SN-' . strtoupper(uniqid());

                $data = [
                    'nama_perangkat' => $nama_perangkat,
                    'tipe_pengajuan' => $request->tipe_pengajuan,
                    'keterangan' => $keteranganList[$index] ?? '-',
                    'sn_perangkat' => $sn,
                ];

                if ($request->tipe_pengajuan === 'Pembelian Baru') {
                    $data['harga'] = $hargaList[$index] ?? 0;
                } else { // Repair Perangkat
                    // Handle file uploads for arrays
                    if ($request->hasFile("foto_sn.{$index}")) {
                        $data['foto_sn'] = $request->file("foto_sn.{$index}")->store('repairs/sn');
                    }
                    if ($request->hasFile("foto_perangkat.{$index}")) {
                        $data['foto_perangkat'] = $request->file("foto_perangkat.{$index}")->store('repairs/perangkat');
                    }
                    $data['harga'] = null;
                }

                // Actually, sparepart needed model is just dummy in this case if SparepartNeededController already handles it.
                // Wait, if I'm intercepting the request and sending to BOTH controllers, 
                // the SparepartNeededController handles saving to SparepartNeeded table.
                // So I only need to save to Sparetracker and LogPergantian here!
                // But wait, my initial implementation created `SparepartNeeded` here. I can keep it, but it's redundant.
                // Let's just create Sparetracker and LogPergantian to avoid double records in Pengajuan.
                
                $trackerStatus = $request->tipe_pengajuan === 'Pembelian Baru' ? 'Tahap Pengadaan' : 'Proses Repair';
                $trackerKondisi = $request->tipe_pengajuan === 'Pembelian Baru' ? 'BAIK' : 'MENUNGGU PENGECEKAN';

                $spareData = [
                    'status_penggunaan_sparepart' => $trackerStatus,
                    'kondisi' => $trackerKondisi,
                    'nama_perangkat' => $nama_perangkat,
                ];

                if ($request->tipe_pengajuan === 'Pembelian Baru') {
                    $spareData['pengadaan_by'] = 'NUSTECH';
                    $spareData['lokasi_asal'] = 'NUSTECH';
                    $spareData['lokasi'] = null;
                    $spareData['tanggal_masuk'] = null;
                }

                // create or update sparetracker based on sn
                $tracker = Sparetracker::updateOrCreate(
                    ['sn' => $sn],
                    $spareData
                );

                LogPergantian::create([
                    'sn_perangkat' => $sn,
                    'keterangan' => 'Pengajuan baru: ' . $request->tipe_pengajuan,
                    'user_id' => auth()->id() ?? 1, 
                ]);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Inventory updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * LOGIKA 2: Halaman Pengiriman
     */
    public function storePengiriman(Request $request)
    {
        $request->validate([
            'nama_ekspedisi' => 'required',
            'no_resi' => 'required',
            'sn_perangkat' => 'required',
            'site_id' => 'required|exists:sites,id', // Assuming site table has id
        ]);

        DB::beginTransaction();
        try {
            $pengiriman = Pengiriman::create([
                'ekspedisi' => $request->nama_ekspedisi,
                'no_resi' => $request->no_resi,
                'sn_perangkat' => $request->sn_perangkat,
                'site_id' => $request->site_id,
                'status' => 'Dikirim',
            ]);

            $tracker = Sparetracker::where('sn', $request->sn_perangkat)->first();
            if ($tracker) {
                $tracker->update([
                    'status_penggunaan_sparepart' => 'Dikirim ke Site',
                    'lokasi' => $request->site_id // Or update other fields accordingly
                ]);

                LogPergantian::create([
                    'sn_perangkat' => $request->sn_perangkat,
                    'keterangan' => 'Perangkat dikirim ke site via ' . $request->nama_ekspedisi,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Pengiriman berhasil dicatat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * LOGIKA 3: Update Status Repair
     */
    public function updateRepairStatus(Request $request, $id)
    {
        $request->validate([
            'kondisi_akhir' => 'required|in:Kondisi Baik,Kondisi Buruk'
        ]);

        $tracker = Sparetracker::findOrFail($id);

        $kondisi = $request->kondisi_akhir === 'Kondisi Baik' ? 'BAIK' : 'BURUK';
        $status_baru = $request->kondisi_akhir === 'Kondisi Baik' ? 'Stok' : 'Rusak/Afkir';

        $tracker->update([
            'kondisi' => $kondisi,
            'status_penggunaan_sparepart' => $status_baru
        ]);

        LogPergantian::create([
            'sn_perangkat' => $tracker->sn,
            'keterangan' => 'Update hasil repair. Kondisi: ' . $kondisi,
        ]);

        return redirect()->back()->with('success', 'Status repair berhasil diupdate!');
    }
}
