<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\City;
use App\Models\Banners;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();
        $banners = Banners::where('is_active', true)
            ->latest()
            ->get();


        return view('pages.home', compact('categories', 'cities', 'banners'));
    }
}
