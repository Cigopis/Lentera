<?php

namespace App\Http\Controllers;

use App\Models\AuctionCatalog;
use App\Models\BrochureDownload;
use App\Models\Category;
use App\Models\City;
use App\Services\BrochureService;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $catalogs = AuctionCatalog::query()
            ->with(['city', 'primaryImage', 'category'])
            ->published()
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

    public function show($slug)
    {
        $catalog = AuctionCatalog::with([
            'city',
            'category',
            'catalogImages',
            'primaryImage',
            'specifications',
            'facilities',
        ])
        ->where('slug', $slug)
        ->published()
        ->firstOrFail();

        return view('pages.lelang.show', compact('catalog'));
    }

    public function downloadBrochure(AuctionCatalog $catalog)
    {
        $pdfContent = app(BrochureService::class)->generate($catalog);

        BrochureDownload::create([
            'catalog_id'    => $catalog->id,
            'ip_address'    => request()->ip(),
            'downloaded_at' => now(),
        ]);

        return response()->streamDownload(
            fn () => print($pdfContent),
            'brosur-' . $catalog->slug . '.pdf'
        );
    }
}