<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HomePortfolio;
use App\Models\HomeNews;
use App\Models\LandingPageContent;
use App\Models\ServiceModalItem;

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

        return view('home', compact('portfolios', 'instagramNews', 'generalNews', 'content', 'modalItems'));
    }
}

