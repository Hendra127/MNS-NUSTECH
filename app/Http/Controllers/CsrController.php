<?php

namespace App\Http\Controllers;

use App\Models\CsrPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\CsrApprovalNotification;
use Illuminate\Support\Facades\Notification;

class CsrController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Map: current approval_status  =>  which role is allowed to approve next
     */
    private const ROLE_GATE = [
        CsrPengajuan::STATUS_PENDING_NOC         => ['noc_leader'],
        CsrPengajuan::STATUS_PENDING             => ['manager'],
        CsrPengajuan::STATUS_APPROVED_MANAGER    => ['accounting'],
        CsrPengajuan::STATUS_APPROVED_ACCOUNTING => ['direktur'],
        CsrPengajuan::STATUS_APPROVED_DIREKTUR   => ['penasihat'],
    ];

    /**
     * Human-friendly label for each role that must approve
     */
    private const ROLE_LABEL = [
        CsrPengajuan::STATUS_PENDING_NOC         => 'NOC Leader',
        CsrPengajuan::STATUS_PENDING             => 'Manager',
        CsrPengajuan::STATUS_APPROVED_MANAGER    => 'Accounting',
        CsrPengajuan::STATUS_APPROVED_ACCOUNTING => 'Direktur',
        CsrPengajuan::STATUS_APPROVED_DIREKTUR   => 'Penasihat',
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

    /** Check if the currently-logged-in user is allowed to act on a CSR in the given status */
    private function canAct(CsrPengajuan $csr): bool
    {
        $user = Auth::user();

        // Creator can never approve their own submission
        if ($csr->user_id === $user->id) {
            return false;
        }

        // Special case for NOC Leader by Name if role 'noc_leader' is not explicitly assigned to the account
        $isRossie = ($user->name === 'Rossie Maulana Septian, S.Kom');
        if ($csr->approval_status === CsrPengajuan::STATUS_PENDING_NOC && $isRossie) {
            return true;
        }

        $allowed = self::ROLE_GATE[$csr->approval_status] ?? [];
        return in_array($user->role, $allowed);
    }

    // -------------------------------------------------------------------------

    public function index(Request $request)
    {
        $query = CsrPengajuan::latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor', 'like', "%{$request->search}%")
                  ->orWhere('divisi', 'like', "%{$request->search}%")
                  ->orWhere('nama_site', 'like', "%{$request->search}%")
                  ->orWhere('nama_penerima', 'like', "%{$request->search}%");
            });
        }

        if ($request->status) {
            $query->where('approval_status', $request->status);
        }

        $csrList = $query->paginate(20)->withQueryString();
        $sites   = \App\Models\Site::orderBy('sitename')->get(['site_id', 'sitename']);
        $userRole = Auth::user()->role;

        return view('csr', compact('csrList', 'sites', 'userRole'));
    }

    // -------------------------------------------------------------------------

    public function store(Request $request)
    {
        $data = $request->validate([
            'tempat_tanggal'        => 'nullable|string',
            'divisi'                => 'nullable|string',
            'nomor'                 => 'nullable|string',
            'nama_site'             => 'required|array', // Allow multiple
            'nama_penerima'         => 'required|string',
            'bank'                  => 'nullable|string',
            'nomor_rekening'        => 'nullable|string',
            'rincian_kebutuhan'     => 'nullable|string',
            'total'                 => 'nullable|integer',
            'terbilang'             => 'nullable|string',
            'pemohon_nama'          => 'nullable|string',
            'pemohon_jabatan'       => 'nullable|string',
            'diverifikasi1_nama'    => 'nullable|string',
            'diverifikasi1_jabatan' => 'nullable|string',
            'diverifikasi2_nama'    => 'nullable|string',
            'diverifikasi2_jabatan' => 'nullable|string',
            'diverifikasi3_nama'    => 'nullable|string',
            'diverifikasi3_jabatan' => 'nullable|string',
            'disetujui_nama'        => 'nullable|string',
            'disetujui_jabatan'     => 'nullable|string',
            'mengetahui_nama'       => 'nullable|string',
            'mengetahui_jabatan'    => 'nullable|string',
        ]);

        $isNocLeader = (Auth::user()->role === 'noc_leader' || Auth::user()->name === 'Rossie Maulana Septian, S.Kom');
        $data['approval_status'] = $isNocLeader ? CsrPengajuan::STATUS_PENDING : CsrPengajuan::STATUS_PENDING_NOC;
        $data['user_id']         = Auth::id();

        // Auto-fill TTD pemohon on submission
        $data['ttd_pemohon'] = self::TTD_PATHS['pemohon'];

        // Convert sites array to string with numbering if > 1
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

        // Handle custom bank name
        if ($request->filled('bank_custom')) {
            $data['bank'] = $request->bank_custom;
        }
        unset($data['bank_custom']);

        // If dropdown selected __custom__, clear it (will be overridden above)
        if (($data['bank'] ?? '') === '__custom__') {
            $data['bank'] = $request->bank_custom ?? '';
        }

        $csr = CsrPengajuan::create($data);

        // Notify NOC Leader if not made by NOC Leader
        if ($data['approval_status'] === CsrPengajuan::STATUS_PENDING_NOC) {
            $nocLeader = User::where('name', 'Rossie Maulana Septian, S.Kom')->orWhere('role', 'noc_leader')->get();
            Notification::send($nocLeader, new CsrApprovalNotification($csr, "Pengajuan CSR baru ({$csr->nomor}) dari " . Auth::user()->name . " menunggu persetujuan NOC Leader."));
            $msg = 'Formulir CSR berhasil disimpan. Menunggu persetujuan NOC Leader.';
        } else {
            // Notify Managers and Superadmins if made by NOC Leader
            $notifiableUsers = User::whereIn('role', ['manager', 'superadmin'])->get();
            Notification::send($notifiableUsers, new CsrApprovalNotification($csr, "Pengajuan CSR baru ({$csr->nomor}) telah dibuat oleh " . Auth::user()->name . ". Menunggu persetujuan Anda."));
            $msg = 'Formulir CSR berhasil disimpan. Menunggu persetujuan Manager.';

            // Send WhatsApp notification to manager
            $waMessage = "📝 *Pengajuan CSR Baru (Menunggu Manager)*\n\n"
                . "📄 *Nomor:* {$csr->nomor}\n"
                . "👤 *Pemohon:* " . Auth::user()->name . " (NOC Leader)\n"
                . "📍 *Site:*" . (str_contains($csr->nama_site, "\n") ? "\n" . trim($csr->nama_site) : " " . trim($csr->nama_site)) . "\n"
                . "💰 *Total:* Rp " . number_format($csr->total, 0, ',', '.') . "\n"
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
        $csr = CsrPengajuan::findOrFail($id);

        // Role gate check
        if (!$this->canAct($csr)) {
            $needed = self::ROLE_LABEL[$csr->approval_status] ?? '?';
            return redirect()->back()->with('error', "Hanya {$needed} yang dapat menyetujui pengajuan ini.");
        }

        $transitions = [
            CsrPengajuan::STATUS_PENDING_NOC         => [CsrPengajuan::STATUS_PENDING,             'approved_noc_at'], // Need to add migration for this column or just use existing
            CsrPengajuan::STATUS_PENDING             => [CsrPengajuan::STATUS_APPROVED_MANAGER,    'approved_manager_at'],
            CsrPengajuan::STATUS_APPROVED_MANAGER    => [CsrPengajuan::STATUS_APPROVED_ACCOUNTING, 'approved_accounting_at'],
            CsrPengajuan::STATUS_APPROVED_ACCOUNTING => [CsrPengajuan::STATUS_APPROVED_DIREKTUR,   'approved_direktur_at'],
            CsrPengajuan::STATUS_APPROVED_DIREKTUR   => [CsrPengajuan::STATUS_APPROVED_PENASIHAT,  'approved_penasihat_at'],
        ];

        if (!isset($transitions[$csr->approval_status])) {
            return redirect()->back()->with('error', 'Status pengajuan sudah final, tidak dapat diubah.');
        }

        [$newStatus, $tsField] = $transitions[$csr->approval_status];

        // Auto-fill TTD for each approval stage
        $ttdAutoFill = [
            CsrPengajuan::STATUS_APPROVED_MANAGER    => ['ttd_manager'    => self::TTD_PATHS['manager']],
            CsrPengajuan::STATUS_APPROVED_ACCOUNTING => ['ttd_accounting' => self::TTD_PATHS['accounting']],
            CsrPengajuan::STATUS_APPROVED_DIREKTUR   => ['ttd_direktur'   => self::TTD_PATHS['direktur']],
            CsrPengajuan::STATUS_APPROVED_PENASIHAT  => ['ttd_penasihat'  => self::TTD_PATHS['penasihat']],
        ];

        $updateData = array_merge(
            ['approval_status' => $newStatus, $tsField => now()],
            $ttdAutoFill[$newStatus] ?? []
        );

        // If accounting is approving, also save no_surat, catatan & keterangan
        if ($csr->approval_status === CsrPengajuan::STATUS_APPROVED_MANAGER) {
            $updateData['no_surat']   = $request->input('no_surat');
            $updateData['catatan']    = $request->input('catatan');
            $updateData['keterangan'] = $request->input('keterangan');
        }

        $csr->update($updateData);

        // Notification Logic
        $pemohon = $csr->user; // Assuming relationship exists
        if (!$pemohon && $csr->user_id) {
            $pemohon = User::find($csr->user_id);
        }

        $approvedByLabels = [
            CsrPengajuan::STATUS_PENDING_NOC         => 'NOC Leader',
            CsrPengajuan::STATUS_PENDING             => 'NOC Leader', // When approving FROM NOC to Manager
            CsrPengajuan::STATUS_APPROVED_MANAGER    => 'Manager',
            CsrPengajuan::STATUS_APPROVED_ACCOUNTING => 'Accounting',
            CsrPengajuan::STATUS_APPROVED_DIREKTUR   => 'Direktur',
            CsrPengajuan::STATUS_APPROVED_PENASIHAT  => 'Penasihat',
        ];
        $who = $approvedByLabels[$newStatus] ?? 'Pejabat';

        // Notify Pemohon
        if ($pemohon) {
            $pemohon->notify(new CsrApprovalNotification($csr, "Pengajuan CSR Anda ({$csr->nomor}) telah disetujui oleh {$who}."));
        }

        // Notify Next Approver
        $nextRole = null;
        if ($newStatus === CsrPengajuan::STATUS_PENDING)             $nextRole = 'manager';
        if ($newStatus === CsrPengajuan::STATUS_APPROVED_MANAGER)    $nextRole = 'accounting';
        if ($newStatus === CsrPengajuan::STATUS_APPROVED_ACCOUNTING) $nextRole = 'direktur';
        if ($newStatus === CsrPengajuan::STATUS_APPROVED_DIREKTUR)   $nextRole = 'penasihat';

        if ($nextRole) {
            $nextUsers = User::whereIn('role', [$nextRole, 'superadmin'])->get();
            Notification::send($nextUsers, new CsrApprovalNotification($csr, "Pengajuan CSR ({$csr->nomor}) telah disetujui oleh {$who} dan menunggu persetujuan Anda."));

            // Send WhatsApp notification
            $roleLabels = [
                'manager' => 'Manager (Anda)',
                'accounting' => 'Keuangan/Accounting (Anda)',
                'direktur' => 'Direktur (Anda)',
                'penasihat' => 'Penasihat (Anda)',
            ];
            $nextLabel = $roleLabels[$nextRole] ?? ucfirst($nextRole);
            
            $waMessage = "📝 *Persetujuan Pengajuan CSR*\n\n"
                . "📄 *Nomor:* {$csr->nomor}\n"
                . "👤 *Pemohon:* " . ($csr->user ? $csr->user->name : $csr->pemohon_nama) . "\n"
                . "📍 *Site:*" . (str_contains($csr->nama_site, "\n") ? "\n" . trim($csr->nama_site) : " " . trim($csr->nama_site)) . "\n"
                . "💰 *Total:* Rp " . number_format($csr->total, 0, ',', '.') . "\n"
                . "👉 *Status Saat Ini:* Disetujui oleh *{$who}*\n"
                . "⚡ *Langkah Berikutnya:* Menunggu persetujuan *{$nextLabel}*\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA\n\n"
                . "Silakan login ke sistem untuk memproses pengajuan ini.";
            \App\Services\WhatsAppService::sendToRole($nextRole, $waMessage);
        }

        // Final approval WA notification
        if ($newStatus === CsrPengajuan::STATUS_APPROVED_PENASIHAT) {
            $waMessage = "✅ *Pengajuan CSR SELESAI & DISETUJUI!*\n\n"
                . "📄 *Nomor:* {$csr->nomor}\n"
                . "👤 *Pemohon:* " . ($csr->user ? $csr->user->name : $csr->pemohon_nama) . "\n"
                . "📍 *Site:*" . (str_contains($csr->nama_site, "\n") ? "\n" . trim($csr->nama_site) : " " . trim($csr->nama_site)) . "\n"
                . "💰 *Total:* Rp " . number_format($csr->total, 0, ',', '.') . "\n"
                . "✨ *Status Akhir:* Telah disetujui oleh *Penasihat* (Proses Lengkap/Selesai)\n"
                . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA";

            if ($pemohon && $pemohon->phone) {
                \App\Services\WhatsAppService::send($pemohon->phone, $waMessage);
            } else {
                \App\Services\WhatsAppService::send(null, $waMessage);
            }
            \App\Services\WhatsAppService::sendToRole('accounting', $waMessage);
        }

        $approvedByLabels = [
            CsrPengajuan::STATUS_APPROVED_MANAGER    => 'Manager',
            CsrPengajuan::STATUS_APPROVED_ACCOUNTING => 'Accounting',
            CsrPengajuan::STATUS_APPROVED_DIREKTUR   => 'Direktur',
            CsrPengajuan::STATUS_APPROVED_PENASIHAT  => 'Penasihat',
        ];

        $who = $approvedByLabels[$newStatus] ?? 'Pejabat';

        // Final approval
        if ($newStatus === CsrPengajuan::STATUS_APPROVED_PENASIHAT) {
            return redirect()->back()->with('success', "✅ CSR telah disetujui oleh Penasihat. Proses SELESAI!");
        }

        $next = self::ROLE_LABEL[$newStatus] ?? '';
        return redirect()->back()->with('success', "✅ Disetujui oleh {$who}. Pengajuan diteruskan ke {$next}.");
    }

    // -------------------------------------------------------------------------

    public function reject(Request $request, $id)
    {
        $csr = CsrPengajuan::findOrFail($id);

        if (!$this->canAct($csr)) {
            $needed = self::ROLE_LABEL[$csr->approval_status] ?? '?';
            return redirect()->back()->with('error', "Hanya {$needed} yang dapat menolak pengajuan ini.");
        }

        $request->validate([
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $rejectorLabel = self::ROLE_LABEL[$csr->approval_status] ?? Auth::user()->role;

        $csr->update([
            'approval_status'  => CsrPengajuan::STATUS_REJECTED,
            'rejected_by'      => $rejectorLabel,
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify Pemohon
        $pemohon = $csr->user ?: User::find($csr->user_id);
        if ($pemohon) {
            $pemohon->notify(new CsrApprovalNotification($csr, "❌ Pengajuan CSR Anda ({$csr->nomor}) DITOLAK oleh {$rejectorLabel}. Alasan: " . ($request->rejection_reason ?: '-')));
        }

        return redirect()->back()->with('success', "❌ CSR ditolak oleh {$rejectorLabel}.");
    }

    // -------------------------------------------------------------------------

    public function print(Request $request, $id)
    {
        $csr     = CsrPengajuan::findOrFail($id);
        $withTtd = $request->boolean('with_ttd', true);
        return view('print_csr', compact('csr', 'withTtd'));
    }

    // -------------------------------------------------------------------------

    public function update(Request $request, $id)
    {
        $csr = CsrPengajuan::findOrFail($id);

        // Only NOC Leader can edit CSR submissions
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat mengedit pengajuan CSR.');
        }

        // Optional: Only allow editing if still pending or rejected (to re-submit)
        // If it's already approved by someone, editing might be restricted.
        // For now, let's allow it but warn the user.

        $data = $request->validate([
            'tempat_tanggal'        => 'nullable|string',
            'divisi'                => 'nullable|string',
            'nomor'                 => 'nullable|string',
            'nama_site'             => 'required|array',
            'nama_penerima'         => 'required|string',
            'bank'                  => 'nullable|string',
            'nomor_rekening'        => 'nullable|string',
            'rincian_kebutuhan'     => 'nullable|string',
            'total'                 => 'nullable|integer',
            'terbilang'             => 'nullable|string',
            'pemohon_nama'          => 'nullable|string',
            'pemohon_jabatan'       => 'nullable|string',
            'diverifikasi1_nama'    => 'nullable|string',
            'diverifikasi1_jabatan' => 'nullable|string',
            'diverifikasi2_nama'    => 'nullable|string',
            'diverifikasi2_jabatan' => 'nullable|string',
            'diverifikasi3_nama'    => 'nullable|string',
            'diverifikasi3_jabatan' => 'nullable|string',
            'disetujui_nama'        => 'nullable|string',
            'disetujui_jabatan'     => 'nullable|string',
            'mengetahui_nama'       => 'nullable|string',
            'mengetahui_jabatan'    => 'nullable|string',
        ]);

        // Convert sites array to string with numbering
        $sites = (array) $request->input('nama_site');
        if (count($sites) > 1) {
            $numbered = [];
            foreach ($sites as $idx => $s) {
                // Remove existing numbering if present to avoid double numbering
                $cleanSite = preg_replace('/^[0-9]+\.\s*/', '', $s);
                $numbered[] = ($idx + 1) . ". " . $cleanSite;
            }
            $data['nama_site'] = implode(PHP_EOL, $numbered);
        } else {
            $data['nama_site'] = preg_replace('/^[0-9]+\.\s*/', '', $sites[0] ?? '');
        }

        // Handle custom bank name
        if ($request->filled('bank_custom')) {
            $data['bank'] = $request->bank_custom;
        }
        unset($data['bank_custom']);

        if (($data['bank'] ?? '') === '__custom__') {
            $data['bank'] = $request->bank_custom ?? '';
        }

        // If it was rejected, resetting it to pending might be desired
        if ($csr->approval_status === CsrPengajuan::STATUS_REJECTED) {
            $data['approval_status'] = CsrPengajuan::STATUS_PENDING;
            $data['rejected_by'] = null;
            $data['rejection_reason'] = null;
        }

        $csr->update($data);

        return redirect()->back()->with('success', 'Formulir CSR berhasil diperbarui.');
    }

    // -------------------------------------------------------------------------

    public function destroy($id)
    {
        // Only NOC Leader can delete CSR submissions
        if (Auth::user()->role !== 'noc_leader') {
            return redirect()->back()->with('error', 'Hanya NOC Leader yang dapat menghapus pengajuan CSR.');
        }

        // Delete the CSR (no additional role checks needed)
        CsrPengajuan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Formulir CSR berhasil dihapus.');
    }

    // -------------------------------------------------------------------------

    public function updateAccountingNotes(Request $request, $id)
    {
        if (Auth::user()->role !== 'accounting') {
            return redirect()->back()->with('error', 'Hanya Accounting yang dapat mengisi catatan dan nomor surat.');
        }

        $csr = CsrPengajuan::findOrFail($id);

        $request->validate([
            'no_surat'   => 'nullable|string|max:255',
            'catatan'    => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $csr->update([
            'no_surat'   => $request->no_surat,
            'catatan'    => $request->catatan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', '✅ Catatan, Nomor Surat, dan Keterangan berhasil disimpan.');
    }
}
