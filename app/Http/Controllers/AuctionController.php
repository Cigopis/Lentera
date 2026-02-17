<?php

namespace App\Http\Controllers;

use App\Models\AuctionCatalog;
use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $query = AuctionCatalog::query()
            ->where('status', 'active');

        // ======================
        // FILTER KATEGORI
        // ======================
        if ($request->kategori) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }

        // ======================
        // FILTER HARGA
        // ======================
        if ($request->min) {
            $query->where('reserve_price', '>=', $request->min);
        }

        if ($request->max) {
            $query->where('reserve_price', '<=', $request->max);
        }

        // ======================
        // FILTER LOKASI
        // ======================
        if ($request->kota) {
            $query->whereHas('city', function ($q) use ($request) {
                $q->whereIn('slug', $request->kota);
            });
        }

        // ======================
        // FILTER BULAN
        // ======================
        if ($request->bulan) {
            $query->whereMonth('auction_date', $request->bulan);
        }

        $catalogs = $query->latest()->get();

        $categories = Category::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();

        return view('pages.lelang.index', compact('catalogs', 'categories', 'cities'));
    }
}