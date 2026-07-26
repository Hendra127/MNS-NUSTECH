<?php

namespace App\Http\Controllers;

use App\Models\CmPengajuan;
use App\Models\User;
use App\Notifications\CsrApprovalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CmController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Map: current approval_status  =>  which role is allowed to approve next
     */
    private const ROLE_GATE = [
        CmPengajuan::STATUS_PENDING_NOC         => ['noc_leader'],
        CmPengajuan::STATUS_PENDING             => ['manager'],
        CmPengajuan::STATUS_APPROVED_MANAGER    => ['accounting'],
        CmPengajuan::STATUS_APPROVED_ACCOUNTING => ['direktur'],
        CmPengajuan::STATUS_APPROVED_DIREKTUR   => ['penasihat'],
    ];

    /**
     * Human-friendly label for each role that must approve
     */
    private const ROLE_LABEL = [
        CmPengajuan::STATUS_PENDING_NOC         => 'NOC Leader',
        CmPengajuan::STATUS_PENDING             => 'Manager',
        CmPengajuan::STATUS_APPROVED_MANAGER    => 'Accounting',
        CmPengajuan::STATUS_APPROVED_ACCOUNTING => 'Direktur',
        CmPengajuan::STATUS_APPROVED_DIREKTUR   => 'Penasihat',
    ];

    /**
     * Signature image paths (relative to public/assets/img/ttd/)
     */
    private const TTD_PATHS = [
        'pemohon'    => 'assets/img/ttd/pemohon.png',
        'manager'    => 'assets/img/ttd/manager.png',
        'accounting' => 'assets/img/ttd/accounting.png',
        'direktur'   => 'assets/img/ttd/direktur.png',
        'penasihat'  => 'assets/img/ttd/penasihat.png',
    ];

    /** Check if the currently-logged-in user is allowed to act on a CM in the given status */
    private function canAct(CmPengajuan $cm): bool
    {
        $user = Auth::user();

        // Creator can never approve their own submission
        if ($cm->user_id === $user->id) {
            return false;
        }

        // Special case for NOC Leader by Name if role 'noc_leader' is not explicitly assigned to the account
        $isRossie = ($user->name === 'Rossie Maulana Septian, S.Kom');
        if ($cm->approval_status === CmPengajuan::STATUS_PENDING_NOC && $isRossie) {
            return true;
        }

        $allowed = self::ROLE_GATE[$cm->approval_status] ?? [];
        return in_array($user->role, $allowed);
    }

    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $query = CmPengajuan::latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor', 'like', "%{$request->search}%")
                  ->orWhere('divisi', 'like', "%{$request->search}%")
                  ->orWhere('nama_site', 'like', "%{$request->search}%")
                  ->orWhere('nama_teknisi', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        if ($request->status_pembayaran) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        $cmList = $query->get();
        $sites   = \App\Models\Site::orderBy('sitename')->get(['site_id', 'sitename']);
        $userRole = Auth::user()->role;

        return view('cm', compact('cmList', 'sites', 'userRole'));
    }

    // -------------------------------------------------------------------------

    public function store(Request $request)
    {
        $data = $request->validate([
            'tempat_tanggal'        => 'nullable|string',
            'divisi'                => 'nullable|string',
            'nomor'                 => 'nullable|string',
            'nama_site'             => 'required|array',
            'tanggal_kunjungan'     => 'nullable|string',
            'nama_teknisi'          => 'nullable|string',
            'bank'                  => 'nullable|string',
            'nomor_rekening'        => 'nullable|string',
            'rincian_kebutuhan'     => 'nullable|string',
            'total'                 => 'nullable|integer',
            'terbilang'             => 'nullable|string',
            'catatan'               => 'nullable|string',
            'pemohon_nama'          => 'nullable|string',
            'pemohon_jabatan'       => 'nullable|string',
            'diverifikasi1_nama'    => 'nullable|string',
            'diverifikasi1_jabatan' => 'nullable|string',
            'diverifikasi2_nama'    => 'nullable|string',
            'diverifikasi2_jabatan' => 'nullable|string',
            'disetujui_nama'        => 'nullable|string',
            'disetujui_jabatan'     => 'nullable|string',
            'mengetahui_nama'       => 'nullable|string',
            'mengetahui_jabatan'    => 'nullable|string',
        ]);

        $isNocLeader = (Auth::user()->role === 'noc_leader' || Auth::user()->name === 'Rossie Maulana Septian, S.Kom');
        $data['approval_status'] = $isNocLeader ? CmPengajuan::STATUS_PENDING : CmPengajuan::STATUS_PENDING_NOC;
        $data['user_id']         = Auth::id();
        $data['ttd_pemohon']     = self::TTD_PATHS['pemohon'];

        // Site list logic
        $sites = (array) $request->input('nama_site');
        if (count($sites) > 1) {
            $numbered = [];
            foreach ($sites as $idx => $s) {
                $numbered[] = ($idx + 1) . ". " . $s;
            }
            $data['nama_site'] = implode(PHP_EOL, $numbered);
        } else {
            $data['nama_site'] = $sites[0] ?? '';
        }

        // Custom bank name
        if ($request->filled('bank_custom')) {
            $data['bank'] = $request->bank_custom;
        }

        $cm = CmPengajuan::create($data);

        // Notification logic
        if ($data['approval_status'] === CmPengajuan::STATUS_PENDING_NOC) {
            $nocLeader = User::where('name', 'Rossie Maulana Septian, S.Kom')->orWhere('role', 'noc_leader')->get();
            Notification::send($nocLeader, new CsrApprovalNotification($cm, "Pengajuan CM baru ({$cm->nomor}) dari " . Auth::user()->name . " menunggu persetujuan NOC Leader.", "CM"));
            $msg = 'Formulir CM berhasil disimpan. Menunggu persetujuan NOC Leader.';
        } else {
            $notifiableUsers = User::whereIn('role', ['manager', 'superadmin'])->get();
            Notification::send($notifiableUsers, new CsrApprovalNotification($cm, "Pengajuan CM baru ({$cm->nomor}) telah dibuat oleh " . Auth::user()->name . ". Menunggu persetujuan Anda.", "CM"));
            $msg = 'Formulir CM berhasil disimpan. Menunggu persetujuan Manager.';

            // Send WhatsApp notification to manager
            $waMessage = "🛠️ *Pengajuan CM Baru (Menunggu Manager)*\n\n"
                . "📄 *Nomor:* {$cm->nomor}\n"
                . "👤 *Pemohon:* " . Auth::user()->name . " (NOC Leader)\n"
                . "📍 *Site:*" . (str_contains($cm->nama_site, "\n") ? "\n" . trim($cm->nama_site) : " " . trim($cm->nama_site)) . "\n"
                . "💰 *Total:* Rp " . number_format($cm->total, 0, ',', '.') . "\n"
                . "⚡ *Langkah Berikutnya:* Menunggu persetujuan *Manager (Anda)*\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA\n\n"
                . "Silakan login ke sistem untuk memproses pengajuan ini.";
            \App\Services\WhatsAppService::sendToRole('manager', $waMessage);
        }

        return redirect()->back()->with('success', $msg);
    }

    // -------------------------------------------------------------------------

    public function approve(Request $request, $id)
    {
        $cm = CmPengajuan::findOrFail($id);

        if (!$this->canAct($cm)) {
            $needed = self::ROLE_LABEL[$cm->approval_status] ?? '?';
            return redirect()->back()->with('error', "Hanya {$needed} yang dapat menyetujui pengajuan ini.");
        }

        $transitions = [
            CmPengajuan::STATUS_PENDING_NOC         => [CmPengajuan::STATUS_PENDING,             'approved_noc_at'],
            CmPengajuan::STATUS_PENDING             => [CmPengajuan::STATUS_APPROVED_MANAGER,    'approved_manager_at'],
            CmPengajuan::STATUS_APPROVED_MANAGER    => [CmPengajuan::STATUS_APPROVED_ACCOUNTING, 'approved_accounting_at'],
            CmPengajuan::STATUS_APPROVED_ACCOUNTING => [CmPengajuan::STATUS_APPROVED_DIREKTUR,   'approved_direktur_at'],
            CmPengajuan::STATUS_APPROVED_DIREKTUR   => [CmPengajuan::STATUS_APPROVED_PENASIHAT,  'approved_penasihat_at'],
        ];

        if (!isset($transitions[$cm->approval_status])) {
            return redirect()->back()->with('error', 'Status pengajuan sudah final.');
        }

        [$newStatus, $tsField] = $transitions[$cm->approval_status];

        $ttdAutoFill = [
            CmPengajuan::STATUS_APPROVED_MANAGER    => ['ttd_manager'    => self::TTD_PATHS['manager']],
            CmPengajuan::STATUS_APPROVED_ACCOUNTING => ['ttd_accounting' => self::TTD_PATHS['accounting']],
            CmPengajuan::STATUS_APPROVED_DIREKTUR   => ['ttd_direktur'   => self::TTD_PATHS['direktur']],
            CmPengajuan::STATUS_APPROVED_PENASIHAT  => ['ttd_penasihat'  => self::TTD_PATHS['penasihat']],
        ];

        $updateData = array_merge(
            ['approval_status' => $newStatus, $tsField => now()],
            $ttdAutoFill[$newStatus] ?? []
        );

        // If accounting is approving, also save no_surat & catatan from request
        if ($cm->approval_status === CmPengajuan::STATUS_APPROVED_MANAGER) {
            $updateData['no_surat']   = $request->input('no_surat');
            $updateData['catatan']    = $request->input('catatan');
            $updateData['keterangan'] = $request->input('keterangan');
        }

        $cm->update($updateData);

        // Notifications
        $pemohon = $cm->user ?: User::find($cm->user_id);
        $approvedByLabels = [
            CmPengajuan::STATUS_PENDING_NOC         => 'NOC Leader',
            CmPengajuan::STATUS_PENDING             => 'NOC Leader', // Transition label
            CmPengajuan::STATUS_APPROVED_MANAGER    => 'Manager',
            CmPengajuan::STATUS_APPROVED_ACCOUNTING => 'Accounting',
            CmPengajuan::STATUS_APPROVED_DIREKTUR   => 'Direktur',
            CmPengajuan::STATUS_APPROVED_PENASIHAT  => 'Penasihat',
        ];
        $who = $approvedByLabels[$cm->approval_status] ?? 'Pejabat';

        if ($pemohon) {
            $pemohon->notify(new CsrApprovalNotification($cm, "Pengajuan CM Anda ({$cm->nomor}) telah disetujui oleh {$who}.", "CM"));
        }

        $nextRole = null;
        if ($newStatus === CmPengajuan::STATUS_PENDING)             $nextRole = 'manager';
        if ($newStatus === CmPengajuan::STATUS_APPROVED_MANAGER)    $nextRole = 'accounting';
        if ($newStatus === CmPengajuan::STATUS_APPROVED_ACCOUNTING) $nextRole = 'direktur';
        if ($newStatus === CmPengajuan::STATUS_APPROVED_DIREKTUR)   $nextRole = 'penasihat';

        if ($nextRole) {
            $nextUsers = User::whereIn('role', [$nextRole, 'superadmin'])->get();
            Notification::send($nextUsers, new CsrApprovalNotification($cm, "Pengajuan CM ({$cm->nomor}) telah disetujui oleh {$who} dan menunggu persetujuan Anda.", "CM"));

            // Send WhatsApp notification
            $roleLabels = [
                'manager' => 'Manager (Anda)',
                'accounting' => 'Keuangan/Accounting (Anda)',
                'direktur' => 'Direktur (Anda)',
                'penasihat' => 'Penasihat (Anda)',
            ];
            $nextLabel = $roleLabels[$nextRole] ?? ucfirst($nextRole);
            
            $waMessage = "🛠️ *Persetujuan Pengajuan CM*\n\n"
                . "📄 *Nomor:* {$cm->nomor}\n"
                . "👤 *Pemohon:* " . ($cm->user ? $cm->user->name : $cm->pemohon_nama) . "\n"
                . "📍 *Site:*" . (str_contains($cm->nama_site, "\n") ? "\n" . trim($cm->nama_site) : " " . trim($cm->nama_site)) . "\n"
                . "💰 *Total:* Rp " . number_format($cm->total, 0, ',', '.') . "\n"
                . "👉 *Status Saat Ini:* Disetujui oleh *{$who}*\n"
                . "⚡ *Langkah Berikutnya:* Menunggu persetujuan *{$nextLabel}*\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA\n\n"
                . "Silakan login ke sistem untuk memproses pengajuan ini.";
            \App\Services\WhatsAppService::sendToRole($nextRole, $waMessage);
        }

        // Final approval WA notification
        if ($newStatus === CmPengajuan::STATUS_APPROVED_PENASIHAT) {
            $waMessage = "✅ *Pengajuan CM SELESAI & DISETUJUI!*\n\n"
                . "📄 *Nomor:* {$cm->nomor}\n"
                . "👤 *Pemohon:* " . ($cm->user ? $cm->user->name : $cm->pemohon_nama) . "\n"
                . "📍 *Site:*" . (str_contains($cm->nama_site, "\n") ? "\n" . trim($cm->nama_site) : " " . trim($cm->nama_site)) . "\n"
                . "💰 *Total:* Rp " . number_format($cm->total, 0, ',', '.') . "\n"
                . "✨ *Status Akhir:* Telah disetujui oleh *Penasihat* (Proses Lengkap/Selesai)\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA";

            if ($pemohon && $pemohon->phone) {
                \App\Services\WhatsAppService::send($pemohon->phone, $waMessage);
            } else {
                \App\Services\WhatsAppService::send(null, $waMessage);
            }
            \App\Services\WhatsAppService::sendToRole('accounting', $waMessage);
        }

        if ($newStatus === CmPengajuan::STATUS_APPROVED_PENASIHAT) {
            return redirect()->back()->with('success', "✅ CM telah disetujui oleh Penasihat. Proses SELESAI!");
        }

        $next = self::ROLE_LABEL[$newStatus] ?? '';
        return redirect()->back()->with('success', "✅ Disetujui oleh {$who}. Pengajuan diteruskan ke {$next}.");
    }

    // -------------------------------------------------------------------------

    public function reject(Request $request, $id)
    {
        $cm = CmPengajuan::findOrFail($id);

        if (!$this->canAct($cm)) {
            $needed = self::ROLE_LABEL[$cm->approval_status] ?? '?';
            return redirect()->back()->with('error', "Hanya {$needed} yang dapat menolak pengajuan ini.");
        }

        $request->validate(['rejection_reason' => 'nullable|string|max:500']);

        $rejectorLabel = self::ROLE_LABEL[$cm->approval_status] ?? Auth::user()->role;

        $cm->update([
            'approval_status'  => CmPengajuan::STATUS_REJECTED,
            'rejected_by'      => $rejectorLabel,
            'rejection_reason' => $request->rejection_reason,
        ]);

        $pemohon = $cm->user ?: User::find($cm->user_id);
        if ($pemohon) {
            $pemohon->notify(new CsrApprovalNotification($cm, "❌ Pengajuan CM Anda ({$cm->nomor}) DITOLAK oleh {$rejectorLabel}.", "CM"));
        }

        return redirect()->back()->with('success', "❌ CM ditolak oleh {$rejectorLabel}.");
    }

    // -------------------------------------------------------------------------

    public function print(Request $request, $id)
    {
        $cm      = CmPengajuan::findOrFail($id);
        $withTtd = $request->boolean('with_ttd', true);
        return view('print_cm', compact('cm', 'withTtd'));
    }

    // -------------------------------------------------------------------------

    public function update(Request $request, $id)
    {
        $cm = CmPengajuan::findOrFail($id);

        // Only NOC Leader can edit CM submissions
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat mengedit pengajuan CM.');
        }

        $data = $request->validate([
            'tempat_tanggal'        => 'nullable|string',
            'divisi'                => 'nullable|string',
            'nomor'                 => 'nullable|string',
            'nama_site'             => 'required|array',
            'tanggal_kunjungan'     => 'nullable|string',
            'nama_teknisi'          => 'nullable|string',
            'bank'                  => 'nullable|string',
            'nomor_rekening'        => 'nullable|string',
            'rincian_kebutuhan'     => 'nullable|string',
            'total'                 => 'nullable|integer',
            'terbilang'             => 'nullable|string',
            'catatan'               => 'nullable|string',
            'pemohon_nama'          => 'nullable|string',
            'pemohon_jabatan'       => 'nullable|string',
            'diverifikasi1_nama'    => 'nullable|string',
            'diverifikasi1_jabatan' => 'nullable|string',
            'diverifikasi2_nama'    => 'nullable|string',
            'diverifikasi2_jabatan' => 'nullable|string',
            'disetujui_nama'        => 'nullable|string',
            'disetujui_jabatan'     => 'nullable|string',
            'mengetahui_nama'       => 'nullable|string',
            'mengetahui_jabatan'    => 'nullable|string',
        ]);

        $sites = (array) $request->input('nama_site');
        if (count($sites) > 1) {
            $numbered = [];
            foreach ($sites as $idx => $s) {
                $cleanSite = preg_replace('/^[0-9]+\.\s*/', '', $s);
                $numbered[] = ($idx + 1) . ". " . $cleanSite;
            }
            $data['nama_site'] = implode(PHP_EOL, $numbered);
        } else {
            $data['nama_site'] = preg_replace('/^[0-9]+\.\s*/', '', $sites[0] ?? '');
        }

        if ($request->filled('bank_custom')) {
            $data['bank'] = $request->bank_custom;
        }

        if ($cm->approval_status === CmPengajuan::STATUS_REJECTED) {
            $isRossie = (Auth::user()->name === 'Rossie Maulana Septian, S.Kom');
            $data['approval_status'] = $isRossie ? CmPengajuan::STATUS_PENDING : CmPengajuan::STATUS_PENDING_NOC;
            $data['rejected_by'] = null;
            $data['rejection_reason'] = null;
        }

        $cm->update($data);

        return redirect()->back()->with('success', 'Formulir CM berhasil diperbarui.');
    }

    // -------------------------------------------------------------------------

    public function destroy($id)
    {
        // Only NOC Leader can delete CM submissions
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat menghapus pengajuan CM.');
        }
        CmPengajuan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Formulir CM berhasil dihapus.');
    }

    // -------------------------------------------------------------------------

    public function updateAccountingNotes(Request $request, $id)
    {
        if (Auth::user()->role !== 'accounting') {
            return redirect()->back()->with('error', 'Hanya Accounting yang dapat mengisi catatan dan nomor surat.');
        }

        $cm = CmPengajuan::findOrFail($id);

        $request->validate([
            'no_surat'          => 'nullable|string|max:255',
            'catatan'           => 'nullable|string',
            'keterangan'        => 'nullable|string',
            'status_pembayaran' => 'nullable|in:belum_dibayar,dp_50,lunas',
            'bukti_dp'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'bukti_transfer'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $updateData = [
            'no_surat'          => $request->no_surat,
            'catatan'           => $request->catatan,
            'keterangan'        => $request->keterangan,
        ];

        if ($request->has('status_pembayaran')) {
            $updateData['status_pembayaran'] = $request->status_pembayaran;
        }

        if ($request->hasFile('bukti_dp')) {
            $path = $request->file('bukti_dp')->store('bukti_dp', 'public');
            $updateData['bukti_dp'] = $path;
        }

        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            $updateData['bukti_transfer'] = $path;
        }

        $cm->update($updateData);

        return redirect()->back()->with('success', '✅ Catatan, Status Pembayaran, dan Data Lainnya berhasil disimpan.');
    }

    // -------------------------------------------------------------------------

    public function markAsDone(Request $request, $id)
    {
        $cm = CmPengajuan::findOrFail($id);

        $cm->update([
            'is_clear' => true,
        ]);

        $accountingUsers = User::where('role', 'accounting')->get();
        Notification::send($accountingUsers, new \App\Notifications\CmDoneNotification($cm));

        $siteStr = str_contains($cm->nama_site, "\n") ? "\n" . trim($cm->nama_site) : " " . trim($cm->nama_site);
        
        $waMessage = "✅ *Notifikasi Pengajuan CM DONE*\n\n"
            . "📋 *Nomor Pengajuan:* {$cm->nomor}\n"
            . "🏢 *Site:*" . $siteStr . "\n\n"
            . "*Pengajuan CM Site diatas sudah selesai dan laporan CM/PM sudah di terima.*\n"
            . "*Silahkan login ke sistem untuk melihat detailnya.*";
        
        \App\Services\WhatsAppService::sendToRole('accounting', $waMessage);

        return redirect()->back()->with('success', '✅ Site dinyatakan DONE.');
    }
}
