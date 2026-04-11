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
                  ->orWhereHas('site', function($q) use ($request) {
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

        return view('sparepart_needed', compact('sparepartsNeeded', 'statuses'));
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
}
