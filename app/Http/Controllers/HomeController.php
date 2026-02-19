<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionCatalog;
use App\Models\Category;
use App\Models\City;
use App\Models\Banners;
use App\Models\GuideSteps;

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

        $catalogs = AuctionCatalog::with(['city', 'primaryImage', 'category'])
            ->published()  // aktif + belum expired

            ->when($request->kategori, function ($query, $slug) {
                $query->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            })

            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('pages.home', compact(
            'categories',
            'cities',
            'banners',
            'catalogs',
            'guideSteps'
        ));
    }
}