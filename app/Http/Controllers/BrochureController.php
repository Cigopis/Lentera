<?php

namespace App\Http\Controllers;

use App\Models\AuctionCatalog;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BrochureController extends Controller
{
    /**
     * Tampilkan brosur di browser + tombol download PNG/PDF via html2canvas
     */
    public function show(AuctionCatalog $catalog)
    {
        $waIcon = $this->getWaIconBase64();
        $catalog->load(['category', 'city', 'facilities', 'catalogImages']);

        $branding = [
            'siteName'        => SystemSetting::getValue('site_name')            ?? 'Lentera',
            'bankName'        => SystemSetting::getValue('bank_name')            ?? '',
            'contactName'     => SystemSetting::getValue('contact_name')         ?? '',
            'contactWhatsapp' => SystemSetting::getValue('contact_whatsapp')     ?? '',
            'brochureFooter'  => SystemSetting::getValue('brochure_footer_text') ?? '',

            // Path logo di storage/app/public/ — set via system_settings
            // Key: brochure_logo_path      → contoh: logos/lentera.png
            // Key: brochure_bank_logo_path → contoh: logos/bri.png
            'logoPath'        => SystemSetting::getValue('brochure_logo_path'),
            'bankLogoPath'    => SystemSetting::getValue('brochure_bank_logo_path'),
        ];

        $visibleImages = $catalog->catalogImages
            ->where('is_visible', true)
            ->sortBy('sort_order')
            ->values();

        $primaryImage = $catalog->primaryImage
            ?? $catalog->catalogImages->firstWhere('is_primary', true)
            ?? $visibleImages->first();

        $catalogData = [
            'title'                => $catalog->title,
            'address'              => $catalog->address,
            'city'                 => $catalog->city?->name,
            'category'             => $catalog->category?->name,
            'reserve_price'        => $catalog->reserve_price,
            'auction_date'         => $catalog->auction_date?->format('Y-m-d'),
            'auction_time'         => $catalog->auction_time,
            'official_auction_url' => $catalog->official_auction_url,
            'grid_mode'            => $catalog->grid_mode ?? 'main+3',
            'main_image'           => $primaryImage?->image_path,
            'images'               => $visibleImages->map(fn($img) => [
                                          'path' => $img->image_path,
                                      ])->values()->toArray(),
            'facilities'           => $catalog->facilities
                                          ->map(fn($f) => ['name' => $f->name])
                                          ->values()->toArray(),
        ];

        return view('brochure.premium', [
            'catalog'  => $catalogData,
            'branding' => $branding,
            'waIcon'   => $waIcon,
        ]);
    }

    private function getWaIconBase64(): ?string
    {
        $path = public_path('images/wa.png'); // simpan icon di sini

        if (!file_exists($path)) {
            return null;
        }

        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);

        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
    /**
     * Download PDF via DomPDF (fallback / admin use)
     */
    public function download(AuctionCatalog $catalog)
    {
        $visibleImages = $catalog->catalogImages
            ->where('is_visible', true)
            ->sortBy('sort_order')
            ->values();

        $primaryImage = $catalog->primaryImage ?? $visibleImages->first();

        $images = $visibleImages->map(fn($img) => [
            'path' => $img->image_path,
        ])->values()->toArray();

        $facilities = $catalog->facilities
            ->map(fn($f) => ['name' => $f->name])
            ->values()
            ->toArray();

        $catalogData = [
            'title'                => $catalog->title,
            'address'              => $catalog->address,
            'city'                 => $catalog->city?->name,
            'category'             => $catalog->category?->name,
            'reserve_price'        => $catalog->reserve_price,
            'auction_date'         => $catalog->auction_date?->format('Y-m-d'),
            'auction_time'         => $catalog->auction_time,
            'official_auction_url' => $catalog->official_auction_url,
            'main_image'           => $primaryImage?->image_path,
            'images'               => $images,
            'grid_mode'            => $catalog->grid_mode ?? 'main+3',
            'facilities'           => $facilities,
        ];

        $branding = [
            'siteName'        => SystemSetting::getValue('site_name')            ?? 'Lentera',
            'bankName'        => SystemSetting::getValue('bank_name')            ?? '',
            'contactName'     => SystemSetting::getValue('contact_name')         ?? '',
            'contactWhatsapp' => SystemSetting::getValue('contact_whatsapp')     ?? '',
            'brochureFooter'  => SystemSetting::getValue('brochure_footer_text') ?? '',
            'logoPath'        => SystemSetting::getValue('brochure_logo_path'),
            'bankLogoPath'    => SystemSetting::getValue('brochure_bank_logo_path'),
        ];

        $waIcon = $this->getWaIconBase64();
        $pdf = Pdf::loadView('brochure', [
            'catalog'  => $catalogData,
            'branding' => $branding,
        ])
        ->setPaper([0, 0, 459, 690.75], 'landscape')
        ->setOption('dpi', 150)
        ->setOption('isRemoteEnabled', true)
        ->setOption('isHtml5ParserEnabled', true);

        $filename = 'brosur-' . $catalog->catalog_code . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Preview PDF di browser (inline)
     */
    public function preview(AuctionCatalog $catalog)
    {
        return $this->download($catalog)->inline();
    }
}