<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HomePortfolio;
use App\Models\HomeNews;
use App\Models\LandingPageContent;
use App\Models\ServiceModalItem;
use App\Models\HomePartner;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Home)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Track page view
        \App\Models\LandingPageView::firstOrCreate(['date' => today()])->increment('views');

        $portfolios = HomePortfolio::orderBy('id', 'desc')->get();
        $instagramNews = HomeNews::where('is_active', true)->where('type', 'instagram')->orderBy('published_at', 'desc')->get();
        $generalNews = HomeNews::where('is_active', true)->where('type', 'general')->orderBy('published_at', 'desc')->get();

        // Load all content settings as key=>value array
        $content = LandingPageContent::getAllAsArray();

        // Load service modal items grouped by modal key
        $modalItems = ServiceModalItem::orderBy('order')->get()->groupBy('modal_key');

        $partners = HomePartner::all();

        return view('home', compact('portfolios', 'instagramNews', 'generalNews', 'content', 'modalItems', 'partners'));
    }

    /**
     * Tampilkan daftar Berita Umum
     */
    public function news()
    {
        $heroNews = HomeNews::where('is_active', true)
            ->where('type', 'general')
            ->orderBy('published_at', 'desc')
            ->first();

        $latestNewsQuery = HomeNews::where('is_active', true)
            ->where('type', 'general')
            ->orderBy('published_at', 'desc');
            
        if ($heroNews) {
            $latestNewsQuery->where('id', '!=', $heroNews->id);
        }
        
        $latestNews = $latestNewsQuery->paginate(8);

        $popularNews = HomeNews::where('is_active', true)
            ->where('type', 'general')
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        $content = LandingPageContent::getAllAsArray();

        return view('news', compact('heroNews', 'latestNews', 'popularNews', 'content'));
    }

    /**
     * Tampilkan detail Berita Umum
     */
    public function newsDetail($id)
    {
        $news = HomeNews::where('is_active', true)
            ->where('type', 'general')
            ->findOrFail($id);
            
        $news->increment('views_count');

        $recentNews = HomeNews::where('is_active', true)
            ->where('type', 'general')
            ->where('id', '!=', $id)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();

        $content = LandingPageContent::getAllAsArray();

        return view('news_detail', compact('news', 'recentNews', 'content'));
    }
}

