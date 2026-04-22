<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CloseTicketExport;
use App\Imports\CloseTicketImport;
use Carbon\Carbon;

class CloseTicketController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->q;
        $kategori = $request->kategori;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;

        // Inisialisasi Query dengan status 'closed'
        $query = Ticket::with(['site', 'evidences'])->where('status', 'closed');

        // 1. Filter Pencarian (Site Code, Nama Site, atau CE)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('site_code', 'like', "%$search%")
                  ->orWhere('nama_site', 'like', "%$search%")
                  ->orWhere('ce', 'like', "%$search%");
            });
        }

        // 2. Filter Kategori (Dari Modal)
        if ($kategori) {
            if ($kategori === 'BMN') {
                $query->whereIn('kategori', ['BMN', 'BARANG MILIK NEGARA (BMN)']);
            } elseif ($kategori === 'SL') {
                $query->whereIn('kategori', ['SL', 'SEWA LAYANAN']);
            } else {
                $query->where('kategori', $kategori);
            }
        }

        // 3. Filter Range Tanggal (Berdasarkan tanggal_close)
        if ($tgl_mulai && $tgl_selesai) {
            $query->whereBetween('tanggal_close', [$tgl_mulai, $tgl_selesai]);
        }

        // 4. Sorting dinamis
        $sortBy = $request->get('sort', 'tanggal_close');
        $sortOrder = $request->get('order', 'desc');
        
        $allowedSorts = ['durasi', 'tanggal_close', 'tanggal_rekap'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'tanggal_close';
        }

        // Ambil data dengan pagination dan pertahankan parameter query di URL
        $perPage = $request->get('per_page', 50);

        $tickets = $query->orderBy($sortBy, $sortOrder)
            ->paginate($perPage)
            ->withQueryString();

        // Hitungan untuk badge
        $closeAllCount = Ticket::where('status', 'closed')->count();
        $todayCount = Ticket::where('status', 'closed')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // Data site untuk modal tambah
        $sites = Site::orderBy('site_code')->get();

        return view('close', compact('tickets', 'sites', 'search', 'closeAllCount', 'todayCount'));
    }

    public function store(Request $request)
    {
        // Validasi menyertakan plan_actions dan ce agar tidak gagal simpan
        $data = $request->validate([
            'site_id'        => 'required|exists:sites,id',
            'site_code'      => 'required|string',
            'nama_site'      => 'required|string',
            'provinsi'       => 'required|string',
            'kabupaten'      => 'required|string',
            'kategori'       => 'required|string',
            'tanggal_rekap'  => 'nullable|date',
            'durasi'         => 'nullable|numeric',
            'kendala'        => 'nullable|string',
            'detail_problem' => 'required|string',
            'plan_actions'   => 'required|string', // Tambahkan ini
            'ce'             => 'required|string',   // Tambahkan ini
        ]);

        // Tambahkan atribut otomatis
        $data['status'] = 'closed'; // Konsisten gunakan 'closed' sesuai database
        $data['tanggal_close'] = Carbon::now(); // Otomatis isi tanggal close hari ini

        Ticket::create($data);

        return redirect()->back()->with('success', 'Ticket Close berhasil ditambahkan');
    }

    public function export(Request $request)
    {
        // Kita kirimkan semua parameter request (q, kategori, tgl_mulai, tgl_selesai) 
        // ke dalam class Export agar hasil download sama dengan yang tampil di layar
        return Excel::download(new CloseTicketExport($request), 'close-ticket.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new CloseTicketImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data close ticket berhasil diimport');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori'       => 'required',
            'tanggal_rekap' => 'required|date',
            'tanggal_close' => 'required|date',
            'kendala'        => 'required',
            'detail_problem' => 'required',
            'plan_actions'   => 'required',
            'ce'             => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);
        
        $tanggalOpen = Carbon::parse($request->tanggal_rekap);
        $tanggalClose = Carbon::parse($request->tanggal_close);
        $durasi = $tanggalOpen->diffInDays($tanggalClose);

        $ticket->update([
            'kategori'       => $request->kategori,
            'tanggal_rekap'  => $request->tanggal_rekap,
            'tanggal_close'  => $request->tanggal_close,
            'durasi'         => $durasi,
            'kendala'        => $request->kendala,
            'detail_problem' => $request->detail_problem,
            'plan_actions'   => $request->plan_actions,
            'ce'             => $request->ce,
            'bulan_open'     => $tanggalOpen->format('F'),
            'bulan_close'    => $tanggalClose->format('F'),
        ]);

        return redirect()->back()->with('success', 'Tiket ' . $ticket->site_code . ' berhasil diupdate!');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }
}