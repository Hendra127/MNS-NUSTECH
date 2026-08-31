<?php

namespace App\Http\Controllers;

use App\Models\SparepartNeeded;
use App\Models\PengajuanSparepart;
use App\Models\Sparetracker;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SparepartNeededController extends Controller
{
    private const ROLE_GATE = [
        'pending_noc'         => ['noc_leader'],
        'pending'             => ['manager'],
        'approved_manager'    => ['accounting'],
        'approved_accounting' => ['direktur'],
        'approved_direktur'   => ['penasihat'],
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function canAct($item): bool
    {
        $user = Auth::user();
        if ($item->user_id === $user->id) return false;
        
        // Special case for Rossie
        $isRossie = ($user->email === 'rossie@nustech.co.id' || $user->name === 'Rossie Maulana Septian, S.Kom');
        if ($item->approval_status === 'pending_noc' && $isRossie) return true;

        $allowed = self::ROLE_GATE[$item->approval_status] ?? [];
        return in_array($user->role, $allowed);
    }

    public function index(Request $request)
    {
        $query = SparepartNeeded::with(['site', 'user']);

        if ($request->search) {
            $query->where('sparepart_name', 'like', "%{$request->search}%")
                ->orWhereHas('site', function ($q) use ($request) {
                    $q->where('sitename', 'like', "%{$request->search}%")
                        ->orWhere('site_id', 'like', "%{$request->search}%");
                });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $sparepartsNeeded = $query->orderByRaw("CASE urgency WHEN 'Urgent' THEN 1 WHEN 'High' THEN 2 WHEN 'Medium' THEN 3 WHEN 'Low' THEN 4 ELSE 5 END")
            ->latest()
            ->paginate(50, ['*'], 'sparepart_page')
            ->withQueryString();
            
        foreach($sparepartsNeeded as $item) {
            $item->can_approve = $this->canAct($item);
        }

        $statuses = SparepartNeeded::select('status')->distinct()->pluck('status')->filter();

        $pengajuansQuery = PengajuanSparepart::with('user')->latest();
        if ($request->status_pembayaran) {
            $pengajuansQuery->where('status_pembayaran', $request->status_pembayaran);
        }
        if ($request->tipe_pengajuan) {
            $pengajuansQuery->where('tipe_pengajuan', $request->tipe_pengajuan);
        }
        if ($request->approval_status) {
            $pengajuansQuery->where('approval_status', $request->approval_status);
        }
        if ($request->search_pengajuan) {
            $pengajuansQuery->where(function ($q) use ($request) {
                $q->where('nomor', 'like', "%{$request->search_pengajuan}%")
                  ->orWhere('divisi', 'like', "%{$request->search_pengajuan}%")
                  ->orWhere('items', 'like', "%{$request->search_pengajuan}%");
            });
        }
        $pengajuans = $pengajuansQuery->paginate(20, ['*'], 'pengajuan_page')->withQueryString();

        foreach($pengajuans as $p) {
            $p->can_approve = $this->canAct($p);
        }

        // Build list of all SNs for the searchable dropdown (only from Spare Tracker)
        $snFromTracker = Sparetracker::whereNotNull('sn')
            ->where('sn', '!=', '')
            ->orderBy('sn')
            ->get(['id', 'sn', 'nama_perangkat', 'jenis', 'kondisi', 'lokasi', 'status_penggunaan_sparepart', 'foto']);

        // Clean SNs from invisible characters/newlines that might break Select2 DOM
        foreach ($snFromTracker as $item) {
            foreach (['sn', 'nama_perangkat', 'jenis', 'kondisi', 'lokasi'] as $col) {
                if ($item->$col) {
                    $item->$col = trim(preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $item->$col));
                }
            }
        }

        $allSNs = ['sparetracker' => $snFromTracker];

        return view('sparepart_needed', compact('sparepartsNeeded', 'statuses', 'pengajuans', 'allSNs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_pengajuan'  => 'required|in:pembelian_baru,repair_perangkat',
            'site_id'         => 'required|exists:sites,site_id',
            'sparepart_name'  => 'required|string|max:255',
            'quantity'        => 'required|integer|min:1',
            'description'     => 'nullable|string',
            'status'          => 'nullable|string',
            'urgency'         => 'nullable|in:Low,Medium,High,Urgent',
            'photo'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_resi'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            // Untuk repair: foto terpasang & foto SN wajib
            'foto_terpasang'  => $request->tipe_pengajuan === 'repair_perangkat' ? 'required|image|mimes:jpeg,png,jpg,gif|max:5120' : 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_sn'         => $request->tipe_pengajuan === 'repair_perangkat' ? 'required|image|mimes:jpeg,png,jpg,gif|max:5120' : 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            // SN perangkat wajib untuk repair agar trigger pengiriman bisa bekerja
            'sn_perangkat'    => $request->tipe_pengajuan === 'repair_perangkat' ? 'required|string|max:255' : 'nullable|string|max:255',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) $photoPath = $request->file('photo')->store('sparepart_needed', 'public');

        $fotoResiPath = null;
        if ($request->hasFile('foto_resi')) $fotoResiPath = $request->file('foto_resi')->store('sparepart_needed', 'public');

        $fotoTerpasangPath = null;
        if ($request->hasFile('foto_terpasang')) $fotoTerpasangPath = $request->file('foto_terpasang')->store('sparepart_needed', 'public');

        $fotoSnPath = null;
        if ($request->hasFile('foto_sn')) $fotoSnPath = $request->file('foto_sn')->store('sparepart_needed', 'public');

        $sparepart = SparepartNeeded::create([
            'tipe_pengajuan' => $request->tipe_pengajuan,
            'site_id' => $request->site_id,
            'sparepart_name' => $request->sparepart_name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'status' => $request->status ?? 'Pending',
            'urgency' => $request->urgency ?? 'Medium',
            'photo' => $photoPath,
            'foto_resi' => $fotoResiPath,
            'foto_terpasang' => $fotoTerpasangPath,
            'foto_sn' => $fotoSnPath,
            'user_id' => Auth::id(),
            'approval_status' => SparepartNeeded::STATUS_PENDING_NOC,
            'price' => $request->tipe_pengajuan === 'repair_perangkat' ? null : $request->price
        ]);

        // Insert/Update ke sparetracker
        if ($request->tipe_pengajuan === 'repair_perangkat') {
            // Untuk REPAIR: cari record yang sudah ada berdasarkan SN, update statusnya
            $snPerangkat = trim($request->sn_perangkat);
            $existingTracker = Sparetracker::whereRaw('TRIM(LOWER(sn)) = LOWER(?)', [$snPerangkat])->first();

            if ($existingTracker) {
                // Update record yang sudah ada
                $existingTracker->update([
                    'status_penggunaan_sparepart' => 'Proses Repair',
                    'sparepart_needed_id'         => $sparepart->id,
                ]);
            } else {
                // Jika SN tidak ditemukan, buat record baru
                Sparetracker::create([
                    'sn'                          => $snPerangkat ?: null,
                    'nama_perangkat'              => $request->sparepart_name,
                    'status_penggunaan_sparepart' => 'Proses Repair',
                    'kondisi'                     => null,
                    'pengadaan_by'                => null,
                    'lokasi'                      => $request->site_id,
                    'lokasi_realtime'             => 'Gudang NOC',
                    'tanggal_masuk'               => null,
                    'sparepart_needed_id'         => $sparepart->id,
                ]);
            }
        } else {
            // Untuk PEMBELIAN BARU: buat record baru sejumlah quantity
            for ($i = 0; $i < $request->quantity; $i++) {
                Sparetracker::create([
                    'sn'                          => null, // SN diisi manual nanti
                    'nama_perangkat'              => $request->sparepart_name,
                    'status_penggunaan_sparepart' => 'Tahap Pengadaan',
                    'kondisi'                     => 'BAIK',
                    'pengadaan_by'                => 'NUSTECH',
                    'lokasi_asal'                 => 'NUSTECH',
                    'lokasi_realtime'             => 'Gudang NOC',
                    'tanggal_masuk'               => null,
                    'sparepart_needed_id'         => $sparepart->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Sparepart needed added successfully.');
    }

    public function update(Request $request, $id)
    {
        // Only NOC Leader can edit Sparepart Needed entries
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat mengedit data Sparepart Needed.');
        }
        $sparepart = SparepartNeeded::findOrFail($id);
        $request->validate([
            'site_id' => 'required|exists:sites,site_id',
            'sparepart_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'urgency' => 'required|in:Low,Medium,High,Urgent',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_resi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_terpasang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_sn' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data = [
            'site_id' => $request->site_id,
            'sparepart_name' => $request->sparepart_name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'status' => $request->status,
            'urgency' => $request->urgency,
        ];

        $photos = ['photo', 'foto_resi', 'foto_terpasang', 'foto_sn'];
        foreach($photos as $p) {
            if ($request->hasFile($p)) {
                if ($sparepart->$p && Storage::disk('public')->exists($sparepart->$p)) {
                    Storage::disk('public')->delete($sparepart->$p);
                }
                $data[$p] = $request->file($p)->store('sparepart_needed', 'public');
            }
        }

        $sparepart->update($data);

        return redirect()->back()->with('success', 'Sparepart needed updated successfully.');
    }

    public function destroy($id)
    {
        // Only NOC Leader can delete Sparepart Needed entries
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat menghapus data Sparepart Needed.');
        }
        $sparepart = SparepartNeeded::findOrFail($id);
        $photos = ['photo', 'foto_resi', 'foto_terpasang', 'foto_sn'];
        foreach ($photos as $p) {
            if ($sparepart->$p && Storage::disk('public')->exists($sparepart->$p)) {
                Storage::disk('public')->delete($sparepart->$p);
            }
        }
        $sparepart->delete();
        return redirect()->back()->with('success', 'Sparepart needed deleted successfully.');
    }

    public function printPengajuan(Request $request)
    {
        $data = $request->all();
        return view('print_pengajuan', compact('data'));
    }

    public function storePengajuan(Request $request)
    {
        $items = [];
        if ($request->has('perangkat')) {
            foreach ($request->perangkat as $index => $perangkat) {
                $itemData = [
                    'perangkat' => $perangkat,
                    'qty' => $request->qty[$index] ?? 1,
                    'harga' => $request->harga[$index] ?? 0,
                    'total' => ($request->qty[$index] ?? 1) * ($request->harga[$index] ?? 0),
                    'layanan' => $request->layanan[$index] ?? 'BMN',
                    'peruntukan' => $request->peruntukan[$index] ?? 'STOK',
                    'keterangan' => $request->keterangan[$index] ?? '-'
                ];

                if ($request->tipe_pengajuan === 'Repair Perangkat') {
                    $itemData['sn_perangkat'] = $request->sn_perangkat[$index] ?? '';
                    
                    if ($request->hasFile("foto_sn.{$index}")) {
                        $itemData['foto_sn'] = $request->file("foto_sn.{$index}")->store('repairs/sn', 'public');
                    }
                    if ($request->hasFile("foto_perangkat.{$index}")) {
                        $itemData['foto_perangkat'] = $request->file("foto_perangkat.{$index}")->store('repairs/perangkat', 'public');
                    }
                }

                $items[] = $itemData;
            }
        }

        $grand_total = array_sum(array_column($items, 'total'));

        $user = Auth::user();
        $isNocLeader = ($user->role === 'noc_leader' || $user->name === 'Rossie Maulana Septian, S.Kom' || $user->email === 'rossie@nustech.co.id');
        $status = $isNocLeader ? 'pending' : PengajuanSparepart::STATUS_PENDING_NOC;

        $pengajuan = PengajuanSparepart::create([
            'tipe_pengajuan' => $request->tipe_pengajuan ?? 'Pembelian Baru',
            'tempat_tanggal' => $request->tempat_tanggal,
            'divisi' => $request->divisi,
            'nomor' => $request->nomor,
            'items' => $items,
            'grand_total' => $grand_total,
            'terbilang' => $request->terbilang,
            'pemohon_nama' => $request->pemohon_nama,
            'pemohon_jabatan' => $request->pemohon_jabatan,
            'diverifikasi1_nama' => $request->diverifikasi1_nama,
            'diverifikasi1_jabatan' => $request->diverifikasi1_jabatan,
            'diverifikasi2_nama' => $request->diverifikasi2_nama,
            'diverifikasi2_jabatan' => $request->diverifikasi2_jabatan,
            'disetujui_nama' => $request->disetujui_nama,
            'disetujui_jabatan' => $request->disetujui_jabatan,
            'mengetahui_nama' => $request->mengetahui_nama,
            'mengetahui_jabatan' => $request->mengetahui_jabatan,
            'user_id' => Auth::id(),
            'approval_status' => $status
        ]);

        if ($status === 'pending') {
            // Send WhatsApp notification to manager
            $waMessage = "⚙️ *Pengajuan Sparepart Baru (Menunggu Manager)*\n\n"
                . "📄 *Nomor:* {$pengajuan->nomor}\n"
                . "👤 *Pemohon:* " . $user->name . " (NOC Leader)\n"
                . "💰 *Total:* Rp " . number_format($pengajuan->grand_total, 0, ',', '.') . "\n"
                . "⚡ *Langkah Berikutnya:* Menunggu persetujuan *Manager (Anda)*\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA\n\n"
                . "Silakan login ke sistem untuk memproses pengajuan ini.";
            \App\Services\WhatsAppService::sendToRole('manager', $waMessage);
        }

        return redirect()->back()->with('success', 'Formulir Pengajuan berhasil disimpan.');
    }

    public function deletePengajuan($id)
    {
        // Only NOC Leader can delete Pengajuan entries
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat menghapus pengajuan ini.');
        }
        $pengajuan = PengajuanSparepart::findOrFail($id);
        $pengajuan->delete();
        return redirect()->back()->with('success', 'Formulir Pengajuan berhasil dihapus.');
    }

    public function approve(Request $request, $id)
    {
        $pengajuan = PengajuanSparepart::findOrFail($id);
        $user = Auth::user();
        $now = now();

        $isRossie = ($user->email === 'rossie@nustech.co.id' || $user->name === 'Rossie Maulana Septian, S.Kom');

        if ($pengajuan->approval_status === 'pending_noc' && ($user->role === 'noc_leader' || $isRossie)) {
            $pengajuan->update(['approval_status' => 'pending', 'approved_noc_at' => $now]);
            $this->sendWhatsAppNotification($pengajuan, 'NOC Leader', 'pending');
            return redirect()->back()->with('success', 'Disetujui oleh NOC Leader.');
        }

        switch ($user->role) {
            case 'manager':
                $pengajuan->update(['approval_status' => 'approved_manager', 'approved_manager_at' => $now]);
                $this->sendWhatsAppNotification($pengajuan, 'Manager', 'approved_manager');
                break;
            case 'accounting':
                $pengajuan->update([
                    'approval_status'       => 'approved_accounting',
                    'approved_accounting_at' => $now,
                    'no_surat'              => $request->input('no_surat'),
                    'catatan'               => $request->input('catatan'),
                    'keterangan'            => $request->input('keterangan'),
                ]);
                $this->sendWhatsAppNotification($pengajuan, 'Accounting', 'approved_accounting');
                break;
            case 'direktur':
                $pengajuan->update(['approval_status' => 'approved_direktur', 'approved_direktur_at' => $now]);
                $this->sendWhatsAppNotification($pengajuan, 'Direktur', 'approved_direktur');
                break;
            case 'penasihat':
                $pengajuan->update(['approval_status' => 'approved_penasihat', 'approved_penasihat_at' => $now]);
                $this->sendWhatsAppNotification($pengajuan, 'Penasihat', 'approved_penasihat');
                break;
            case 'admin':
            case 'superadmin':
                $this->autoAdvance($pengajuan);
                $this->sendWhatsAppNotification($pengajuan, 'Admin/Superadmin', $pengajuan->approval_status);
                break;
        }

        return redirect()->back()->with('success', 'Persetujuan berhasil diperbarui.');
    }

    public function reject(Request $request, $id)
    {
        $pengajuan = PengajuanSparepart::findOrFail($id);
        $pengajuan->update([
            'approval_status' => 'rejected',
            'rejected_at' => now(),
            'rejected_by' => Auth::user()->name,
            'rejection_reason' => $request->reason
        ]);
        return redirect()->back()->with('error', 'Pengajuan telah ditolak.');
    }

    private function autoAdvance($pengajuan)
    {
        $stages = [
            'pending_noc'         => ['pending', 'approved_noc_at'],
            'pending'             => ['approved_manager', 'approved_manager_at'],
            'approved_manager'    => ['approved_accounting', 'approved_accounting_at'],
            'approved_accounting' => ['approved_direktur', 'approved_direktur_at'],
            'approved_direktur'   => ['approved_penasihat', 'approved_penasihat_at'],
        ];

        if (isset($stages[$pengajuan->approval_status])) {
            $next = $stages[$pengajuan->approval_status];
            $pengajuan->update([
                'approval_status' => $next[0],
                $next[1] => now()
            ]);
        }
    }

    private function sendWhatsAppNotification($pengajuan, $whoApproved, $newStatus)
    {
        $nextRole = null;
        if ($newStatus === 'pending')             $nextRole = 'manager';
        if ($newStatus === 'approved_manager')    $nextRole = 'accounting';
        if ($newStatus === 'approved_accounting') $nextRole = 'direktur';
        if ($newStatus === 'approved_direktur')   $nextRole = 'penasihat';

        if ($nextRole) {
            $roleLabels = [
                'manager' => 'Manager (Anda)',
                'accounting' => 'Keuangan/Accounting (Anda)',
                'direktur' => 'Direktur (Anda)',
                'penasihat' => 'Penasihat (Anda)',
            ];
            $nextLabel = $roleLabels[$nextRole] ?? ucfirst($nextRole);
            
            $waMessage = "⚙️ *Persetujuan Pengajuan Sparepart*\n\n"
                . "📄 *Nomor:* {$pengajuan->nomor}\n"
                . "👤 *Pemohon:* " . ($pengajuan->user ? $pengajuan->user->name : $pengajuan->pemohon_nama) . "\n"
                . "💰 *Total:* Rp " . number_format($pengajuan->grand_total, 0, ',', '.') . "\n"
                . "👉 *Status Saat Ini:* Disetujui oleh *{$whoApproved}*\n"
                . "⚡ *Langkah Berikutnya:* Menunggu persetujuan *{$nextLabel}*\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA\n\n"
                . "Silakan login ke sistem untuk memproses pengajuan ini.";
            \App\Services\WhatsAppService::sendToRole($nextRole, $waMessage);
        }

        if ($newStatus === 'approved_penasihat') {
            $waMessage = "✅ *Pengajuan Sparepart SELESAI & DISETUJUI!*\n\n"
                . "📄 *Nomor:* {$pengajuan->nomor}\n"
                . "👤 *Pemohon:* " . ($pengajuan->user ? $pengajuan->user->name : $pengajuan->pemohon_nama) . "\n"
                . "💰 *Total:* Rp " . number_format($pengajuan->grand_total, 0, ',', '.') . "\n"
                . "✨ *Status Akhir:* Telah disetujui oleh *Penasihat* (Proses Lengkap/Selesai)\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA";

            $pemohon = $pengajuan->user;
            if ($pemohon && $pemohon->phone) {
                \App\Services\WhatsAppService::send($pemohon->phone, $waMessage);
            } else {
                \App\Services\WhatsAppService::send(null, $waMessage);
            }
            \App\Services\WhatsAppService::sendToRole('accounting', $waMessage);
        }
    }

    public function updatePengajuan(Request $request, $id)
    {
        // Only NOC Leader can edit Pengajuan entries
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat mengedit pengajuan ini.');
        }

        $pengajuan = PengajuanSparepart::findOrFail($id);

        $items = [];
        $existingItems = is_array($pengajuan->items) ? $pengajuan->items : [];
        if ($request->has('perangkat')) {
            foreach ($request->perangkat as $index => $perangkat) {
                $itemData = [
                    'perangkat' => $perangkat,
                    'qty' => $request->qty[$index] ?? 1,
                    'harga' => $request->harga[$index] ?? 0,
                    'total' => ($request->qty[$index] ?? 1) * ($request->harga[$index] ?? 0),
                    'layanan' => $request->layanan[$index] ?? 'BMN',
                    'peruntukan' => $request->peruntukan[$index] ?? 'STOK',
                    'keterangan' => $request->keterangan[$index] ?? '-'
                ];

                if ($request->tipe_pengajuan === 'Repair Perangkat') {
                    $itemData['sn_perangkat'] = $request->sn_perangkat[$index] ?? ($existingItems[$index]['sn_perangkat'] ?? '');
                    
                    if ($request->hasFile("foto_sn.{$index}")) {
                        $itemData['foto_sn'] = $request->file("foto_sn.{$index}")->store('repairs/sn', 'public');
                    } else {
                        $itemData['foto_sn'] = $existingItems[$index]['foto_sn'] ?? null;
                    }
                    if ($request->hasFile("foto_perangkat.{$index}")) {
                        $itemData['foto_perangkat'] = $request->file("foto_perangkat.{$index}")->store('repairs/perangkat', 'public');
                    } else {
                        $itemData['foto_perangkat'] = $existingItems[$index]['foto_perangkat'] ?? null;
                    }
                }

                $items[] = $itemData;
            }
        }

        $grand_total = array_sum(array_column($items, 'total'));

        // Reset approval status back to pending / pending_noc on edit (so it can be re-submitted and re-approved)
        $user = Auth::user();
        $isNocLeader = ($user->role === 'noc_leader' || $user->name === 'Rossie Maulana Septian, S.Kom' || $user->email === 'rossie@nustech.co.id');
        $status = $isNocLeader ? 'pending' : PengajuanSparepart::STATUS_PENDING_NOC;

        $pengajuan->update([
            'tipe_pengajuan' => $request->tipe_pengajuan ?? 'Pembelian Baru',
            'tempat_tanggal' => $request->tempat_tanggal,
            'divisi' => $request->divisi,
            'nomor' => $request->nomor,
            'items' => $items,
            'grand_total' => $grand_total,
            'terbilang' => $request->terbilang,
            'pemohon_nama' => $request->pemohon_nama,
            'pemohon_jabatan' => $request->pemohon_jabatan,
            'diverifikasi1_nama' => $request->diverifikasi1_nama,
            'diverifikasi1_jabatan' => $request->diverifikasi1_jabatan,
            'diverifikasi2_nama' => $request->diverifikasi2_nama,
            'diverifikasi2_jabatan' => $request->diverifikasi2_jabatan,
            'disetujui_nama' => $request->disetujui_nama,
            'disetujui_jabatan' => $request->disetujui_jabatan,
            'mengetahui_nama' => $request->mengetahui_nama,
            'mengetahui_jabatan' => $request->mengetahui_jabatan,
            'approval_status' => $status
        ]);

        if ($status === 'pending') {
            // Send WhatsApp notification to manager
            $waMessage = "⚙️ *Pengajuan Sparepart Diperbarui (Menunggu Manager)*\n\n"
                . "📄 *Nomor:* {$pengajuan->nomor}\n"
                . "👤 *Pemohon:* " . $user->name . " (NOC Leader)\n"
                . "💰 *Total:* Rp " . number_format($pengajuan->grand_total, 0, ',', '.') . "\n"
                . "⚡ *Langkah Berikutnya:* Menunggu persetujuan *Manager (Anda)*\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA\n\n"
                . "Silakan login ke sistem untuk memproses pengajuan ini.";
            \App\Services\WhatsAppService::sendToRole('manager', $waMessage);
        }

        return redirect()->back()->with('success', 'Formulir Pengajuan berhasil diperbarui.');
    }

    // -------------------------------------------------------------------------

    public function updateAccountingNotes(Request $request, $id)
    {
        if (Auth::user()->role !== 'accounting') {
            return redirect()->back()->with('error', 'Hanya Accounting yang dapat mengisi catatan dan nomor surat.');
        }

        $pengajuan = PengajuanSparepart::findOrFail($id);

        $request->validate([
            'no_surat'          => 'nullable|string|max:255',
            'catatan'           => 'nullable|string',
            'status_pembayaran' => 'nullable|in:belum_dibayar,dp_50,lunas',
            'bukti_dp'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'bukti_transfer'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $updateData = [
            'no_surat' => $request->no_surat,
            'catatan'  => $request->catatan,
        ];

        if ($request->has('status_pembayaran')) {
            $updateData['status_pembayaran'] = $request->status_pembayaran;
        }

        if ($request->hasFile('bukti_dp')) {
            $path = $request->file('bukti_dp')->store('bukti_dp_sparepart', 'public');
            $updateData['bukti_dp'] = $path;
        }

        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer_sparepart', 'public');
            $updateData['bukti_transfer'] = $path;
        }

        $pengajuan->update($updateData);

        return redirect()->back()->with('success', '✅ Nomor Surat, Catatan, dan Status Pembayaran berhasil disimpan.');
    }

    // -------------------------------------------------------------------------

    /**
     * Print an existing PengajuanSparepart record by ID.
     * Accepts ?with_ttd=1 (default) or ?with_ttd=0 to toggle signatures.
     */
    public function printPengajuanById(\Illuminate\Http\Request $request, $id)
    {
        $pengajuan = PengajuanSparepart::findOrFail($id);
        $withTtd   = $request->boolean('with_ttd', true);

        // Re-build the flat $data array that print_pengajuan.blade.php expects
        $data = [
            'tempat_tanggal'        => $pengajuan->tempat_tanggal,
            'divisi'                => $pengajuan->divisi,
            'nomor'                 => $pengajuan->nomor,
            'terbilang'             => $pengajuan->terbilang,
            'pemohon_nama'          => $pengajuan->pemohon_nama,
            'pemohon_jabatan'       => $pengajuan->pemohon_jabatan,
            'diverifikasi1_nama'    => $pengajuan->diverifikasi1_nama,
            'diverifikasi1_jabatan' => $pengajuan->diverifikasi1_jabatan,
            'diverifikasi2_nama'    => $pengajuan->diverifikasi2_nama,
            'diverifikasi2_jabatan' => $pengajuan->diverifikasi2_jabatan,
            'disetujui_nama'        => $pengajuan->disetujui_nama,
            'disetujui_jabatan'     => $pengajuan->disetujui_jabatan,
            'mengetahui_nama'       => $pengajuan->mengetahui_nama,
            'mengetahui_jabatan'    => $pengajuan->mengetahui_jabatan,
        ];

        // Unpack JSON items array into parallel arrays
        if (is_array($pengajuan->items)) {
            foreach ($pengajuan->items as $item) {
                $data['perangkat'][]  = $item['perangkat']  ?? '';
                $data['qty'][]        = $item['qty']        ?? 1;
                $data['harga'][]      = $item['harga']      ?? 0;
                $data['layanan'][]    = $item['layanan']    ?? 'BMN';
                $data['peruntukan'][] = $item['peruntukan'] ?? 'STOK';
                $data['keterangan'][] = $item['keterangan'] ?? '-';
            }
        }

        return view('print_pengajuan', compact('data', 'withTtd', 'pengajuan'));
    }
}
