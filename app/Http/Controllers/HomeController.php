<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HomePortfolio;
use App\Models\HomeNews;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Home)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $portfolios = HomePortfolio::orderBy('id', 'desc')->get();
        $news = HomeNews::orderBy('published_at', 'desc')->get();

        return view('home', compact('portfolios', 'news'));
    }
}
