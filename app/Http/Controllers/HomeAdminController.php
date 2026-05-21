<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePortfolio;
use App\Models\HomeNews;
use Illuminate\Support\Facades\Storage;

class HomeAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function checkAccess()
    {
        if (!auth()->user()->hasAdminAccess()) {
            abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
        }
    }

    /**
     * Tampilkan halaman dashboard Admin untuk Landing Page
     */
    public function index()
    {
        $this->checkAccess();

        $portfolios = HomePortfolio::orderBy('id', 'desc')->get();
        $news = HomeNews::orderBy('published_at', 'desc')->get();

        return view('admin.home', compact('portfolios', 'news'));
    }

    /**
     * Simpan Portofolio baru
     */
    public function storePortfolio(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // max 5MB
        ]);

        $imagePath = $request->file('image')->store('portfolios', 'public');

        HomePortfolio::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Portofolio berhasil ditambahkan.');
    }

    /**
     * Update Portofolio
     */
    public function updatePortfolio(Request $request, $id)
    {
        $this->checkAccess();

        $portfolio = HomePortfolio::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($portfolio->image_path) {
                Storage::disk('public')->delete($portfolio->image_path);
            }
            $data['image_path'] = $request->file('image')->store('portfolios', 'public');
        }

        $portfolio->update($data);

        return redirect()->back()->with('success', 'Portofolio berhasil diupdate.');
    }

    /**
     * Hapus Portofolio
     */
    public function destroyPortfolio($id)
    {
        $this->checkAccess();

        $portfolio = HomePortfolio::findOrFail($id);

        if ($portfolio->image_path) {
            Storage::disk('public')->delete($portfolio->image_path);
        }

        $portfolio->delete();

        return redirect()->back()->with('success', 'Portofolio berhasil dihapus.');
    }

    /**
     * Simpan Berita Instagram baru
     */
    public function storeNews(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'title' => 'required|string|max:255',
            'instagram_url' => 'nullable|url|max:500',
            'caption' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
        }

        HomeNews::create([
            'title' => $request->title,
            'instagram_url' => $request->instagram_url,
            'image_path' => $imagePath,
            'caption' => $request->caption,
            'published_at' => $request->published_at ? : now(),
        ]);

        return redirect()->back()->with('success', 'Instagram post berhasil ditambahkan.');
    }

    /**
     * Update Berita Instagram
     */
    public function updateNews(Request $request, $id)
    {
        $this->checkAccess();

        $news = HomeNews::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'instagram_url' => 'nullable|url|max:500',
            'caption' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'published_at' => 'nullable|date',
        ]);

        $data = [
            'title' => $request->title,
            'instagram_url' => $request->instagram_url,
            'caption' => $request->caption,
            'published_at' => $request->published_at ? : $news->published_at,
        ];

        if ($request->hasFile('image')) {
            if ($news->image_path) {
                Storage::disk('public')->delete($news->image_path);
            }
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        $news->update($data);

        return redirect()->back()->with('success', 'Instagram post berhasil diupdate.');
    }

    /**
     * Hapus Berita Instagram
     */
    public function destroyNews($id)
    {
        $this->checkAccess();

        $news = HomeNews::findOrFail($id);

        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();

        return redirect()->back()->with('success', 'Instagram post berhasil dihapus.');
    }
}
