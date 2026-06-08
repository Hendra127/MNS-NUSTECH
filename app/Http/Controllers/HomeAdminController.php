<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePortfolio;
use App\Models\HomeNews;
use App\Models\LandingPageContent;
use App\Models\ServiceModalItem;
use Illuminate\Support\Str;

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
     * Simpan file gambar menggunakan Storage Laravel
     * Disimpan di storage/app/public/ dan bisa diakses via symlink public/storage_public
     */
    private function storeImageToPublic($file, string $subfolder): string
    {
        $path = $file->store($subfolder, 'public');
        return "storage_public/{$path}";
    }

    /**
     * Hapus file gambar
     */
    private function deleteImageFromPublic(?string $imagePath): void
    {
        if (!$imagePath) return;

        if (\Illuminate\Support\Str::startsWith($imagePath, 'uploads/')) {
            if (file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
        } else {
            $path = str_replace(['storage/', 'storage_public/'], '', $imagePath);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        }
    }

    /**
     * Tampilkan halaman dashboard Admin untuk Landing Page
     */
    public function index()
    {
        $this->checkAccess();

        $portfolios = HomePortfolio::orderBy('id', 'desc')->get();
        $instagramNews = HomeNews::where('type', 'instagram')->orderBy('published_at', 'desc')->get();
        $generalNews = HomeNews::where('type', 'general')->orderBy('published_at', 'desc')->get();

        // Get total views
        $totalViews = \App\Models\LandingPageView::sum('views');
        
        // Get chart data for the last 7 days
        $recentViews = \App\Models\LandingPageView::orderBy('date', 'desc')->limit(7)->get()->reverse();
        
        // Format for Chart.js
        $chartLabels = $recentViews->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        });
        $chartData = $recentViews->pluck('views');

        // Load content settings grouped
        $contentItems = LandingPageContent::orderBy('group')->orderBy('order')->get();
        $content = $contentItems->pluck('value', 'key')->toArray();

        // Load service modal items grouped by modal key
        $modalItems = ServiceModalItem::orderBy('order')->get()->groupBy('modal_key');

        return view('admin.home', compact('portfolios', 'instagramNews', 'generalNews', 'totalViews', 'chartLabels', 'chartData', 'content', 'contentItems', 'modalItems'));
    }

    /**
     * Simpan Portofolio baru
     */
    public function storePortfolio(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $imagePath = $this->storeImageToPublic($request->file('image'), 'portfolios');

        HomePortfolio::create([
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
            'image_path'  => $imagePath,
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
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = [
            'title'       => $request->title,
            'category'    => $request->category,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $this->deleteImageFromPublic($portfolio->image_path);
            $data['image_path'] = $this->storeImageToPublic($request->file('image'), 'portfolios');
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

        $this->deleteImageFromPublic($portfolio->image_path);
        $portfolio->delete();

        return redirect()->back()->with('success', 'Portofolio berhasil dihapus.');
    }

    /**
     * Simpan Berita/News baru
     */
    public function storeNews(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'title'         => 'required|string|max:255',
            'type'          => 'required|in:instagram,general',
            'instagram_url' => 'nullable|url|max:500',
            'caption'       => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'published_at'  => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->storeImageToPublic($request->file('image'), 'news');
        }

        HomeNews::create([
            'title'         => $request->title,
            'type'          => $request->type,
            'instagram_url' => $request->instagram_url,
            'image_path'    => $imagePath,
            'caption'       => $request->caption,
            'published_at'  => $request->published_at ?: now(),
        ]);

        $message = $request->type === 'general' ? 'Berita Umum' : 'Instagram post';
        return redirect()->back()->with('success', "{$message} berhasil ditambahkan.");
    }

    /**
     * Update Berita/News
     */
    public function updateNews(Request $request, $id)
    {
        $this->checkAccess();

        $news = HomeNews::findOrFail($id);

        $request->validate([
            'title'         => 'required|string|max:255',
            'type'          => 'required|in:instagram,general',
            'instagram_url' => 'nullable|url|max:500',
            'caption'       => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'published_at'  => 'nullable|date',
        ]);

        $data = [
            'title'         => $request->title,
            'type'          => $request->type,
            'instagram_url' => $request->instagram_url,
            'caption'       => $request->caption,
            'published_at'  => $request->published_at ?: $news->published_at,
        ];

        if ($request->hasFile('image')) {
            $this->deleteImageFromPublic($news->image_path);
            $data['image_path'] = $this->storeImageToPublic($request->file('image'), 'news');
        }

        $news->update($data);

        $message = $request->type === 'general' ? 'Berita Umum' : 'Instagram post';
        return redirect()->back()->with('success', "{$message} berhasil diupdate.");
    }

    /**
     * Hapus Berita/News
     */
    public function destroyNews($id)
    {
        $this->checkAccess();

        $news = HomeNews::findOrFail($id);

        $this->deleteImageFromPublic($news->image_path);
        $news->delete();

        $message = $news->type === 'general' ? 'Berita Umum' : 'Instagram post';
        return redirect()->back()->with('success', "{$message} berhasil dihapus.");
    }

    /**
     * Toggle Tampilkan di Web
     */
    public function toggleNewsActive($id)
    {
        $this->checkAccess();

        $news = HomeNews::findOrFail($id);
        $news->is_active = !$news->is_active;
        $news->save();

        $status  = $news->is_active ? 'ditampilkan' : 'disembunyikan';
        $message = $news->type === 'general' ? 'Berita Umum' : 'Instagram post';
        return redirect()->back()->with('success', "{$message} berhasil {$status} di web.");
    }

    /**
     * Update Landing Page Content Settings
     */
    public function updateContent(Request $request)
    {
        $this->checkAccess();

        $request->validate([
            'content' => 'required|array',
        ]);

        foreach ($request->content as $key => $value) {
            LandingPageContent::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->back()->with('success', 'Konten landing page berhasil diperbarui.');
    }

    /**
     * Simpan item modal baru
     */
    public function storeModalItem(Request $request)
    {
        $this->checkAccess();
        $request->validate([
            'modal_key'   => 'required|string',
            'title'       => 'required|string|max:500',
            'year'        => 'nullable|string|max:50',
            'client'      => 'nullable|string|max:300',
            'description' => 'nullable|string|max:1000',
        ]);

        $lastOrder = ServiceModalItem::where('modal_key', $request->modal_key)->max('order') ?? 0;

        ServiceModalItem::create([
            'modal_key'   => $request->modal_key,
            'title'       => $request->title,
            'year'        => $request->year,
            'client'      => $request->client,
            'description' => $request->description,
            'order'       => $lastOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Item modal berhasil ditambahkan.');
    }

    /**
     * Update item modal yang ada
     */
    public function updateModalItem(Request $request, $id)
    {
        $this->checkAccess();
        $request->validate([
            'title'       => 'required|string|max:500',
            'year'        => 'nullable|string|max:50',
            'client'      => 'nullable|string|max:300',
            'description' => 'nullable|string|max:1000',
        ]);

        $item = ServiceModalItem::findOrFail($id);
        $item->update($request->only(['title', 'year', 'client', 'description']));

        return redirect()->back()->with('success', 'Item modal berhasil diperbarui.');
    }

    /**
     * Hapus item modal
     */
    public function destroyModalItem($id)
    {
        $this->checkAccess();
        ServiceModalItem::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item modal berhasil dihapus.');
    }
}
