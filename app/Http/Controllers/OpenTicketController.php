<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketExport;
use App\Imports\TicketImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class OpenTicketController extends Controller
{
    public function index(Request $request)
    {
        // 1. Menghitung jumlah open dan open hari ini
        $openAllCount = Ticket::where('status', 'open')->count();
        $openTodayCount = Ticket::where('status', 'open')
                                ->whereDate('created_at', \Carbon\Carbon::today())
                                ->count();
    
        // 2. Menghitung jumlah menggunakan teks asli database (mendukung variasi penulisan)
        $countBMN = Ticket::where('status', 'open')
                          ->whereIn('kategori', ['BMN', 'BARANG MILIK NEGARA (BMN)'])
                          ->count();
                          
        $countSL = Ticket::where('status', 'open')
                         ->whereIn('kategori', ['SL', 'SEWA LAYANAN'])
                         ->count();
    
        // 3. Mengambil semua input untuk filter & search
        $search = $request->q;
        $status_tiket = $request->status_tiket;
        $kategori = $request->kategori;
        $provinsi = $request->provinsi;
    
        // 4. Query dasar
        $tickets = Ticket::with(['site', 'evidences'])
            ->where('status', 'open')
            
            ->when($search, function ($q) use ($search) {
                $q->where(function($query) use ($search) {
                    $query->where('site_code', 'like', "%$search%")
                        ->orWhere('nama_site', 'like', "%$search%")
                        ->orWhere('kabupaten', 'like', "%$search%");
                });
            })
    
            ->when($status_tiket, function ($q) use ($status_tiket) {
                return $q->where('status_tiket', $status_tiket);
            })
    
            // Jika user memfilter kategori lewat modal, pastikan value di modal juga sesuai
            ->when($kategori, function ($q) use ($kategori) {
                if ($kategori === 'BMN') {
                    return $q->whereIn('kategori', ['BMN', 'BARANG MILIK NEGARA (BMN)']);
                } elseif ($kategori === 'SL') {
                    return $q->whereIn('kategori', ['SL', 'SEWA LAYANAN']);
                }
                return $q->where('kategori', $kategori);
            })
    
            ->when($provinsi, function ($q) use ($provinsi) {
                return $q->where('provinsi', 'like', "%$provinsi%");
            });
    
        // 5. Sorting
        $sortBy = $request->get('sort', 'tanggal_rekap');
        $sortOrder = $request->get('order', 'desc');
        
        // Allowed sort columns
        $allowedSorts = ['tanggal_rekap', 'durasi'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'tanggal_rekap';
        }

        $actualSortBy = 'tanggal_rekap';
        $actualSortOrder = $sortOrder;

        if ($sortBy === 'durasi') {
            // Durasi ASC (Kecil ke Besar) = Tanggal Rekap DESC (Terbaru ke Lama)
            // Durasi DESC (Besar ke Kecil) = Tanggal Rekap ASC (Lama ke Terbaru)
            $actualSortOrder = ($sortOrder === 'asc') ? 'desc' : 'asc';
        }

        $perPage = $request->get('per_page', 50);

        $tickets = $tickets->orderBy($actualSortBy, $actualSortOrder)
            ->paginate($perPage)
            ->withQueryString();
    
        $sites = \App\Models\Site::orderBy('site_id', 'asc')->get();
        $today = Ticket::whereDate('created_at', \Carbon\Carbon::today())->count();
        $wgTunnels = config('wireguard.tunnels', []);
    
        return view('open', compact('tickets', 'sites', 'search', 'today', 'openAllCount', 'openTodayCount', 'countBMN', 'countSL', 'wgTunnels'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id'        => 'required', // ID Primary Key dari tabel sites
            'site_code'      => 'required|string',
            'nama_site'      => 'required|string',
            'provinsi'       => 'required|string',
            'kabupaten'      => 'required|string',
            'kategori'       => 'required|string',
            'tanggal_rekap'  => 'nullable|date',
            'durasi'         => 'nullable|numeric',
            'durasi_akhir'   => 'nullable|numeric',
            'kendala'        => 'nullable|string',
            'hardware_problem' => 'nullable|array',
            'detail_problem' => 'required|string',
            'status'         => 'required|string',
            'plan_actions'    => 'nullable|string',
            'ce'             => 'nullable|string',
            'evidence'       => 'nullable|array',
            'evidence.*'     => 'file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);


        // Cek apakah sudah ada tiket OPEN untuk site tersebut
        $existingTicket = Ticket::where('site_id', $request->site_id)
                                ->where('status', 'open')
                                ->first();

        if ($existingTicket) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Gagal! Tiket untuk Site {$request->nama_site} sudah ada dan masih berstatus OPEN.");
        }

        // Process hardware_problem array to string
        if (isset($data['hardware_problem']) && is_array($data['hardware_problem'])) {
            $data['hardware_problem'] = implode(',', $data['hardware_problem']);
        }

        // Handle File Upload (Support Multiple)
        $files = $request->file('evidence');
        if ($files) {
            if (!is_array($files)) {
                $files = [$files];
            }
            
            // Hapus evidence dari array data utama agar tidak error saat create (karena disimpan di tabel berbeda)
            unset($data['evidence']);
            $ticket = Ticket::create($data);

            foreach ($files as $file) {
                $path = $file->store('evidence', 'public');
                \App\Models\TicketEvidence::create([
                    'ticket_id' => $ticket->id,
                    'path' => $path
                ]);
            }
        } else {
            Ticket::create($data);
        }

        return redirect()->back()->with('success', 'Ticket berhasil ditambahkan secara permanen.');
    }

    public function export()
    {
        return Excel::download(new TicketExport, 'open-ticket.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new TicketImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data ticket berhasil diimport');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori'       => 'required',
            'tanggal_rekap'  => 'required|date',
            'kendala'        => 'required',
            'hardware_problem' => 'nullable|array',
            'detail_problem' => 'required',
            'plan_actions'    => 'required',
            'ce'             => 'required',
            'evidence'       => 'nullable|array',
            'evidence.*'     => 'file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        $ticket = Ticket::findOrFail($id);
        
        // Update data
        $ticket->kategori       = $request->kategori;
        $ticket->tanggal_rekap  = $request->tanggal_rekap;
        $ticket->kendala        = $request->kendala;
        
        if ($request->has('hardware_problem')) {
            $ticket->hardware_problem = is_array($request->hardware_problem) ? implode(',', $request->hardware_problem) : $request->hardware_problem;
        } else {
            $ticket->hardware_problem = null;
        }

        $ticket->detail_problem = $request->detail_problem;
        $ticket->plan_actions    = $request->plan_actions;
        $ticket->ce             = $request->ce;
        
        // Handle File Upload (Append Multiple)
        $files = $request->file('evidence');
        if ($files) {
            if (!is_array($files)) {
                $files = [$files];
            }
            
            foreach ($files as $file) {
                $path = $file->store('evidence', 'public');
                \App\Models\TicketEvidence::create([
                    'ticket_id' => $ticket->id,
                    'path' => $path
                ]);
            }
        }

        // Update bulan_open otomatis
        $ticket->bulan_open     = \Carbon\Carbon::parse($request->tanggal_rekap)->format('F');

        $ticket->save();

        return redirect()->back()->with('success', 'Tiket ' . $ticket->site_code . ' berhasil diupdate!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }
    // Di dalam Controller Anda
    public function closeTicket(Request $request, $id)
    {
        $request->validate([
            'tanggal_close' => 'required|date',
            'detail_problem' => 'required',
            'plan_actions' => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);

        $tanggalOpen = \Carbon\Carbon::parse($ticket->tanggal_rekap);
        $tanggalClose = \Carbon\Carbon::parse($request->tanggal_close);

        $durasi = $tanggalOpen->diffInDays($tanggalClose);

        $ticket->update([
            'status'        => 'closed',
            'tanggal_close' => $request->tanggal_close,
            'durasi'        => $durasi,
            'bulan_close'   => $tanggalClose->format('F'),
            'detail_problem'=> $request->detail_problem,
            'plan_actions'  => $request->plan_actions,
        ]);

        return redirect()->back()->with('success', 'Tiket ' . $ticket->nama_site . ' berhasil dipindahkan ke Close Tiket.');
    }
    
}