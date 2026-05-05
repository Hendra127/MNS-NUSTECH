<?php

namespace App\Http\Controllers;

use App\Models\SparepartNeeded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SparepartNeededController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = SparepartNeeded::with('site');

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

        // Sort by urgency then created_at
        $sparepartsNeeded = $query->orderByRaw("CASE urgency WHEN 'Urgent' THEN 1 WHEN 'High' THEN 2 WHEN 'Medium' THEN 3 WHEN 'Low' THEN 4 ELSE 5 END")
            ->latest()
            ->paginate(50)
            ->withQueryString();
        $statuses = SparepartNeeded::select('status')->distinct()->pluck('status')->filter();

        $pengajuans = \App\Models\PengajuanSparepart::latest()->paginate(20, ['*'], 'pengajuan_page');

        return view('sparepart_needed', compact('sparepartsNeeded', 'statuses', 'pengajuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'site_id' => 'required|exists:sites,site_id',
            'sparepart_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'urgency' => 'nullable|in:Low,Medium,High,Urgent',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('sparepart_needed', 'public');
        }

        SparepartNeeded::create([
            'site_id' => $request->site_id,
            'sparepart_name' => $request->sparepart_name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'status' => $request->status ?? 'Pending',
            'urgency' => $request->urgency ?? 'Medium',
            'photo' => $photoPath
        ]);

        return redirect()->back()->with('success', 'Sparepart needed added successfully.');
    }

    public function update(Request $request, $id)
    {
        $sparepart = SparepartNeeded::findOrFail($id);

        $request->validate([
            'site_id' => 'required|exists:sites,site_id',
            'sparepart_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'urgency' => 'required|in:Low,Medium,High,Urgent',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        $data = [
            'site_id' => $request->site_id,
            'sparepart_name' => $request->sparepart_name,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'status' => $request->status,
            'urgency' => $request->urgency,
        ];

        if ($request->hasFile('photo')) {
            if ($sparepart->photo && Storage::disk('public')->exists($sparepart->photo)) {
                Storage::disk('public')->delete($sparepart->photo);
            }
            $data['photo'] = $request->file('photo')->store('sparepart_needed', 'public');
        }

        $sparepart->update($data);

        return redirect()->back()->with('success', 'Sparepart needed updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $sparepart = SparepartNeeded::findOrFail($id);
        $request->validate([
            'status' => 'required|string'
        ]);

        $sparepart->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function destroy($id)
    {
        $sparepart = SparepartNeeded::findOrFail($id);

        if ($sparepart->photo && Storage::disk('public')->exists($sparepart->photo)) {
            Storage::disk('public')->delete($sparepart->photo);
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
                $items[] = [
                    'perangkat' => $perangkat,
                    'qty' => $request->qty[$index] ?? 1,
                    'harga' => $request->harga[$index] ?? 0,
                    'total' => ($request->qty[$index] ?? 1) * ($request->harga[$index] ?? 0),
                    'layanan' => $request->layanan[$index] ?? 'BMN',
                    'peruntukan' => $request->peruntukan[$index] ?? 'STOK',
                    'keterangan' => $request->keterangan[$index] ?? '-'
                ];
            }
        }

        $grand_total = array_sum(array_column($items, 'total'));

        \App\Models\PengajuanSparepart::create([
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
        ]);

        return redirect()->back()->with('success', 'Formulir Pengajuan berhasil disimpan.');
    }

    public function deletePengajuan($id)
    {
        $pengajuan = \App\Models\PengajuanSparepart::findOrFail($id);
        $pengajuan->delete();

        return redirect()->back()->with('success', 'Formulir Pengajuan berhasil dihapus.');
    }
}
