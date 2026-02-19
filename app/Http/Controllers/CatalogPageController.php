<?php

namespace App\Http\Controllers;

use App\Models\AuctionCatalog;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CatalogPageController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $catalogs = AuctionCatalog::query()
            ->where('status', 'active')
            ->whereDate('auction_date', '>=', Carbon::today())
            ->when($request->kategori, function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->kategori);
                });
            })
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('pages.katalog', compact('categories', 'catalogs'));
    }
}
