<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionCatalog;
use App\Models\Category;
use App\Models\City;
use App\Models\Banners;
use App\Models\GuideSteps;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        
        $categories = Category::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();
        $guideSteps = GuideSteps::orderBy('step_number')->get();
        $banners = Banners::where('is_active', true)
            ->latest()
            ->get();

        $heroBanners = Banners::where('is_active', true)
            ->where('type', 'hero')
            ->latest()
            ->get();

        $promoBanners = Banners::where('is_active', true)
            ->where('type', 'promo')
            ->latest()
            ->get();


        $today=carbon::now();
        $catalogQuery = AuctionCatalog::with(['city', 'primaryImage', 'category'])
            // ->published()
            ->when($request->kategori, function ($query, $slug) {
                $query->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            })
            ->where('auction_date', '>=', $today) 
            ->orderBy('auction_date', 'asc'); 

        $totalCatalogs = AuctionCatalog::published()->count();

       $catalogs = (clone $catalogQuery)
        ->latest()
        ->take(4)
        ->get();

        return view('pages.home', compact(
            'categories',
            'cities',
            'heroBanners',
            'promoBanners',
            'catalogs',
            'totalCatalogs',
            'guideSteps'
        ));
    }
}