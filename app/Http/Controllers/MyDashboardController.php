<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\PMLiberta; // Import model PMLiberta
use Carbon\Carbon;
use App\Models\Message; // Import model Message
use App\Models\JadwalPiket; // Import model Piket
use App\Models\LaporanCM; // Import model LaporanCM
use Illuminate\Support\Facades\Log;

class MyDashboardController extends Controller
{
    public function index()
{
    // Ambil waktu sekarang (WITA)
    $now = Carbon::now('Asia/Makassar');
    $today = $now->format('Y-m-d');
    $currentTime = $now->format('H:i');

    // 1. Ambil data Tiket Open untuk tabel di dashboard
    $tickets = Ticket::where('status', 'open')
        ->latest()
        ->get();

    // 2. Hitung Statistik Utama (Ticket)
    $todayCount = Ticket::whereDate('created_at', $today)
        ->where('status', 'open')
        ->count();
    $totalOpen = Ticket::where('status', 'open')->count();
    $todayDateLabel = $now->translatedFormat('d M');
    
    // 3. Statistik PM (Diambil dari Model PMLiberta)
    $pmBmnDone = PMLiberta::where('kategori', 'BMN')->where('status', 'DONE')->count();
    $pmBmnTotal = PMLiberta::where('kategori', 'BMN')->count();

    $pmSlDone = PMLiberta::where('kategori', 'SL')->where('status', 'DONE')->count();
    $pmSlTotal = PMLiberta::where('kategori', 'SL')->count();

    // 3b. Statistik CM (Diambil dari Model LaporanCM)
    $cmDone = LaporanCM::whereIn('laporan_cm', ['DONE', 'Done', 'done', 'Done '])->count();
    $cmTotal = LaporanCM::count();

    // 4. Data untuk Sidebar (Group by Detail Problem)
    $sidebarTickets = Ticket::where('status', 'open')
        ->select('detail_problem', 'nama_site') 
        ->get()
        ->groupBy('detail_problem');

    // ==========================================================
    // 5. LOGIKA OTOMATIS SHIFT BERDASARKAN JAM (FIXED)
    // ==========================================================
    
    // Kode Shift Berdasarkan Jam Sekarang
    $currentShiftCode = match (true) {
        $currentTime >= '07:30' && $currentTime < '15:30' => 'P', // Pagi
        $currentTime >= '15:30' && $currentTime < '23:30' => 'S', // Siang
        ($currentTime >= '23:30' || $currentTime < '07:30') => 'M', // Malam (Sesuai Permintaan)
        default => 'OFF',
    };

    // Logika Tanggal Efektif: Jika Shift Malam dan jam antara 00:00 - 07:30, gunakan tanggal kemarin
    $effectiveDate = ($currentShiftCode === 'M' && $currentTime < '07:30') 
        ? $now->copy()->subDay()->format('Y-m-d') 
        : $today;

    // Ambil Personil yang piket HANYA pada shift yang sedang aktif saat ini
    $piketHariIni = \App\Models\JadwalPiket::with(['user', 'shift'])
        ->whereDate('tanggal', $effectiveDate)
        ->whereHas('shift', function($query) use ($currentShiftCode) {
            $query->where('kode', 'LIKE', $currentShiftCode);
        })
        ->get()
        ->filter(function($p) {
            $name = $p->user?->name ?? $p->nama_petugas ?? null;
            return !empty($name) && strtolower((string)$name) !== 'null';
        })
        ->values();

    // Tentukan Teks Jam Kerja untuk ditampilkan di Header Dashboard
    $jamTeks = match($currentShiftCode) {
        'P' => '07:30 - 15:30',
        'S' => '15:30 - 23:30',
        'M' => '23:30 - 07:30', // Jam shift malam diperbaiki
        default => 'Libur'
    };

    $shiftInfo = Carbon::parse($effectiveDate)->translatedFormat('d M') . " " . $jamTeks . " WITA";

    // 6. Kirim semua variabel ke view 'mydashboard'
    return view('mydashboard', compact(
        'tickets', 
        'todayCount', 
        'totalOpen', 
        'pmBmnDone',
        'pmBmnTotal',
        'pmSlDone',
        'pmSlTotal',
        'sidebarTickets',
        'piketHariIni',
        'shiftInfo',
        'todayDateLabel',
        'cmDone',
        'cmTotal'
    ));
}
    public function getDetail($id)
    {
        try {
            // Fetch by ID to be more specific
            $ticket = Ticket::with('site')->find($id);

            if (!$ticket) {
                return response()->json(['error' => 'Data tidak ditemukan'], 404);
            }
            
            return response()->json([
                'nama_site' => $ticket->nama_site,
                'site_id'   => $ticket->site_code,
                'kategori'  => $ticket->kategori ?? '-',
                'provinsi'  => $ticket->provinsi ?? '-',
                'kabupaten' => $ticket->kabupaten ?? '-',
                'sumber_listrik' => $ticket->sumber_listrik ?? '-',
                'durasi'    => $ticket->tanggal_rekap ? Carbon::parse($ticket->tanggal_rekap)->diffInDays(now()) : 0,
                'detail_problem' => $ticket->detail_problem ?? '-',
                'ce'        => $ticket->ce ?? '-',
                'evidence'  => $ticket->evidence,
                
                // AMBIL DARI RELASI SITE
                'latitude'  => $ticket->site?->latitude ?? 0, 
                'longitude' => $ticket->site?->longitude ?? 0,
                'ip_router' => $ticket->site?->ip_router ?? '-',
                'tipe'      => $ticket->site?->tipe ?? '-',
                'wg_tunnel' => 'client_' . str_pad($ticket->site?->id ?? 0, 5, '0', STR_PAD_LEFT)
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
public function fetchMessages(Request $request) {
    $currentUserId = auth()->id();
    $currentGuestName = $request->get('guest_name');

    $messages = \App\Models\Message::with(['user', 'parent.user'])
        ->latest()
        ->take(50)
        ->get()
        ->reverse()
        ->map(function ($msg) use ($currentUserId, $currentGuestName) {
            if (auth()->check()) {
                $msg->is_me = ($msg->user_id === $currentUserId);
            } else {
                // Untuk guest, kita cocokkan berdasarkan guest_name yang dikirim klien
                $msg->is_me = is_null($msg->user_id) && !empty($currentGuestName) && ($msg->guest_name === $currentGuestName);
            }
            
            $msg->is_sender_admin = $msg->user ? (bool)$msg->user->is_admin : (bool)$msg->is_admin;
            
            return $msg;
        })
        ->values();

    return response()->json($messages);
}
public function storeMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string',
        'guest_name' => 'nullable|string|max:50',
        'parent_id' => 'nullable|exists:messages,id'
    ]);

    $user = auth()->user();

    $chat = \App\Models\Message::create([
        'user_id'    => auth()->check() ? auth()->id() : null,
        'guest_name' => !auth()->check() ? $request->guest_name : null,
        'message'    => $request->message,
        'parent_id'  => $request->parent_id,
        // Kolom is_admin di database (status pesan)
        'is_admin'   => auth()->check() ? ($user->is_admin ?? false) : false,
    ]);

    $chat->load(['user', 'parent.user']);

    // Tambahkan atribut tambahan agar JS bisa langsung baca label (ADMIN)
    $chat->is_sender_admin = $user ? (bool)$user->is_admin : false;

    // === KIRIM NOTIFIKASI WHATSAPP VIA FONNTE ===
    try {
        $senderName = $user ? $user->name : ($request->guest_name ?? 'Guest');
        $isAdmin = $user ? ($user->is_admin ? ' (Admin)' : '') : '';
        $waMessage = "💬 *Chat Baru di Dashboard*\n\n"
                   . "👤 *Dari:* {$senderName}{$isAdmin}\n"
                   . "📝 *Pesan:* {$request->message}\n"
                   . "🕐 *Waktu:* " . now()->timezone('Asia/Makassar')->format('d/m/Y H:i') . " WITA";

        $fonteToken = env('FONNTE_TOKEN');
        $targetNumber = env('WHATSAPP_NOTIFY_NUMBER', '6281332809923');

        if ($fonteToken) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $fonteToken,
                ],
                CURLOPT_POSTFIELDS => [
                    'target' => $targetNumber,
                    'message' => $waMessage,
                ],
                CURLOPT_TIMEOUT => 5,
            ]);
            $waResult = curl_exec($curl);
            \Log::info('Fonnte WA Response: ' . $waResult);
            curl_close($curl);
        }
    } catch (\Exception $e) {
        \Log::error('Fonnte WA Error: ' . $e->getMessage());
    }

    return response()->json($chat);
}
    public function getFilteredTickets(Request $request)
    {
        try {
            $type = $request->get('type');
            $label = "Ticket List";
            $tickets = [];

            if ($type == 'today' || $type == 'all_open') {
                $query = \App\Models\Ticket::query();
                if ($type == 'today') {
                    $query->whereDate('created_at', now());
                    $label = "Tickets Today";
                } else {
                    $query->where('status', 'open');
                    $label = "All Open Tickets";
                }
                
                $tickets = $query->get()->map(function($item) {
                    $durasiStr = "0 Hari";
                    if ($item->tanggal_rekap) {
                        $durasiStr = floor(\Carbon\Carbon::parse($item->tanggal_rekap)->diffInDays(now())) . " Hari";
                    }
                    return [
                        'nama_site' => $item->nama_site,
                        'site_code' => $item->site_code,
                        'status'    => strtoupper($item->status),
                        'display_date' => $durasiStr
                    ];
                });
            } 
            elseif ($type == 'pm_bmn' || $type == 'pm_sl') {
                $kategori = ($type == 'pm_bmn') ? 'BMN' : 'SL';
                $label = "PM " . $kategori . " Done";

                $tickets = \App\Models\PMLiberta::where('kategori', $kategori)
                    ->where('status', 'DONE')
                    ->get()
                    ->map(function($item) {
                        return [
                            'nama_site' => $item->nama_lokasi ?? '-', 
                            'site_code' => $item->site_id ?? '-',
                            'status'    => 'DONE',
                            'display_date' => $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : '-'
                        ];
                    });
            } 
            elseif ($type == 'cm_all') {
                $label = "CM (All) Done";
                $tickets = \App\Models\LaporanCM::whereIn('laporan_cm', ['DONE', 'Done', 'done', 'Done '])
                    ->latest()
                    ->get()
                    ->map(function($item) {
                        return [
                            'nama_site' => $item->nama_site ?? '-',
                            'site_code' => $item->site_id ?? '-',
                            'status'    => 'DONE',
                            'display_date' => $item->tanggal_on_site ? \Carbon\Carbon::parse($item->tanggal_on_site)->format('Y-m-d') : '-'
                        ];
                    });
            }

            return response()->json([
                'success' => true,
                'tickets' => $tickets,
                'type_label' => $label
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function fetchStats()
    {
        try {
            $now = Carbon::now('Asia/Makassar');
            $today = $now->format('Y-m-d');
            $currentTime = $now->format('H:i');

            // 1. Stats
            $todayCount = Ticket::whereDate('created_at', $today)
                ->where('status', 'open')
                ->count();
            $totalOpen = Ticket::where('status', 'open')->count();
            $todayDateLabel = $now->translatedFormat('d M');
            $pmBmnDone = PMLiberta::where('kategori', 'BMN')->where('status', 'DONE')->count();
            $pmBmnTotal = PMLiberta::where('kategori', 'BMN')->count();
            $pmSlDone = PMLiberta::where('kategori', 'SL')->where('status', 'DONE')->count();
            $pmSlTotal = PMLiberta::where('kategori', 'SL')->count();
            $cmDone = LaporanCM::whereIn('laporan_cm', ['DONE', 'Done', 'done', 'Done '])->count();
            $cmTotal = LaporanCM::count();

            // 2. Piket
            $currentShiftCode = match (true) {
                $currentTime >= '07:30' && $currentTime < '15:30' => 'P',
                $currentTime >= '15:30' && $currentTime < '23:30' => 'S',
                ($currentTime >= '23:30' || $currentTime < '07:30') => 'M',
                default => 'OFF',
            };

            // Logika Tanggal Efektif (Sama dengan index)
            $effectiveDate = ($currentShiftCode === 'M' && $currentTime < '07:30') 
                ? $now->copy()->subDay()->format('Y-m-d') 
                : $today;

            $piketHariIni = \App\Models\JadwalPiket::with(['user', 'shift'])
                ->whereDate('tanggal', $effectiveDate)
                ->whereHas('shift', function($query) use ($currentShiftCode) {
                    $query->where('kode', 'LIKE', $currentShiftCode);
                })
                ->get()
                ->filter(function($p) {
                    $name = $p->user?->name ?? $p->nama_petugas ?? null;
                    return !empty($name) && strtolower((string)$name) !== 'null';
                })
                ->values();
            $jamTeks = match($currentShiftCode) {
                'P' => '07:30 - 15:30',
                'S' => '15:30 - 23:30',
                'M' => '23:30 - 07:30',
                default => 'Libur'
            };
            $shiftInfo = Carbon::parse($effectiveDate)->translatedFormat('d M') . " " . $jamTeks . " WITA";

            // 3. Sidebar (Open Ticket Problem)
            $sidebar = Ticket::where('status', 'open')
                ->select('detail_problem', 'nama_site')
                ->get()
                ->groupBy('detail_problem');

            // 4. Main Table (Dynamic based on selected filter)
            $type = request('type', 'all_open');
            $table = [];
            $typeLabel = "All Open Tickets";

            if ($type == 'today' || $type == 'all_open') {
                $query = Ticket::query();
                if ($type == 'today') {
                    $query->whereDate('created_at', $today);
                    $typeLabel = "Tickets Today";
                } else {
                    $query->where('status', 'open');
                    $typeLabel = "All Open Tickets";
                }
                
                $table = $query->latest()->get()->map(function($t) {
                    $tglRekap = Carbon::parse($t->tanggal_rekap)->startOfDay();
                    $tglAkhir = (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close) 
                        ? Carbon::parse($t->tanggal_close)->startOfDay() 
                        : now()->startOfDay();
                    
                    return [
                        'id'        => $t->id,
                        'nama_site' => $t->nama_site,
                        'site_code' => $t->site_code,
                        'status'    => strtoupper($t->status),
                        'durasi'    => floor($tglRekap->diffInDays($tglAkhir)) . " Hari"
                    ];
                });
            } elseif ($type == 'pm_bmn' || $type == 'pm_sl') {
                $kategori = ($type == 'pm_bmn') ? 'BMN' : 'SL';
                $typeLabel = "PM " . $kategori . " Done";

                $table = PMLiberta::where('kategori', $kategori)
                    ->where('status', 'DONE')
                    ->latest()
                    ->get()
                    ->map(function($item) {
                        return [
                            'nama_site' => $item->nama_lokasi ?? '-', 
                            'site_code' => $item->site_id ?? '-',
                            'status'    => 'DONE',
                            'durasi'    => $item->date ? Carbon::parse($item->date)->format('Y-m-d') : '-'
                        ];
                    });
            } elseif ($type == 'cm_all') {
                $typeLabel = "CM (All) Done";
                $table = LaporanCM::where('laporan_cm', 'DONE')
                    ->latest()
                    ->get()
                    ->map(function($item) {
                        return [
                            'nama_site' => $item->nama_site ?? '-',
                            'site_code' => $item->site_id ?? '-',
                            'status'    => 'DONE',
                            'durasi'    => $item->tanggal_on_site ? Carbon::parse($item->tanggal_on_site)->format('Y-m-d') : '-'
                        ];
                    });
            }

            return response()->json([
                'success' => true,
                'stats' => [
                    'todayCount' => $todayCount,
                    'totalOpen' => $totalOpen,
                    'pmBmnDone' => $pmBmnDone,
                    'pmBmnTotal' => $pmBmnTotal,
                    'pmSlDone' => $pmSlDone,
                    'pmSlTotal' => $pmSlTotal,
                    'cmDone' => $cmDone,
                    'cmTotal' => $cmTotal,
                    'todayDateLabel' => $todayDateLabel,
                ],
                'piket' => [
                    'status' => $piketHariIni->isNotEmpty() ? 'Shift On' : 'No Shift',
                    'info' => $shiftInfo,
                    'list' => $piketHariIni->map(function($p) {
                        return [
                            'name' => $p->user?->name ?? $p->nama_petugas ?? 'Unknown',
                            'shift_kode' => $p->shift->kode ?? '?'
                        ];
                    })
                ],
                'sidebar' => $sidebar,
                'table' => $table,
                'type_label' => $typeLabel,
                'type' => $type
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}