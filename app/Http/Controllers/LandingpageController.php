<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingpageController extends Controller
{
    public function index()
    {
        return view('landingpage');
    }

    public function todo()
    {
        return view('pages.todo');
    }
}