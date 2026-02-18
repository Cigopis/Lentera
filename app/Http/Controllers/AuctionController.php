<?php

namespace App\Http\Controllers;

use App\Models\AuctionCatalog;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $catalogs = AuctionCatalog::query()
        ->with(['city', 'primaryImage', 'category'])
        ->where('status', 'active')
        ->filter($request)
        ->latest()
        ->paginate(9)
        ->withQueryString();

        $categories = Category::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();

        return view('pages.lelang.index', compact(
            'catalogs',
            'categories',
            'cities'
        ));
    }
}
