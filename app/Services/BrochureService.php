<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\AuctionCatalog;
use App\Models\Brochure;
use App\Models\SystemSetting;
use Barryvdh\DomPDF\Facade\Pdf;

class BrochureService
{
    public function generate(AuctionCatalog $catalog)
    {
        // Ambil relasi supaya tidak lazy load di view
        $catalog->load(['category', 'city', 'facilities', 'catalogImages']);

        $branding = [
            'siteName'             => SystemSetting::getValue('siteName'),
            'siteTagline'          => SystemSetting::getValue('siteTagline'),
            'contactWhatsapp'      => SystemSetting::getValue('contactWhatsapp'),
            'contactEmail'         => SystemSetting::getValue('contactEmail'),
            'contactAddress'       => SystemSetting::getValue('contactAddress'),
            'footerText'           => SystemSetting::getValue('footerText'),
            'brochureFooter'       => SystemSetting::getValue('brochureFooter'),
            'brochureShowWhatsapp' => SystemSetting::getValue('brochureShowWhatsapp'),
            'brochurePriceLabel'   => SystemSetting::getValue('brochurePriceLabel'),
            'bankName'             => SystemSetting::getValue('bankName'),
        ];

        // Visible images terurut untuk grid
        $visibleImages = $catalog->catalogImages
            ->where('is_visible', true)
            ->sortBy('sort_order')
            ->values();

        $primaryImage = $catalog->catalogImages->firstWhere('is_primary', true)
            ?? $visibleImages->first();

        $snapshotCatalog = [
            'catalog_code'         => $catalog->catalog_code,
            'title'                => $this->clean($catalog->title),
            'slug'                 => $catalog->slug,
            'description'          => $this->clean(strip_tags($catalog->description)),
            'reserve_price'        => $catalog->reserve_price,
            'deposit_amount'       => $catalog->deposit_amount,
            'address'              => $this->clean($catalog->address),
            'auction_date'         => $catalog->auction_date,
            'auction_time'         => $catalog->auction_time,
            'official_auction_url' => $catalog->official_auction_url,
            'category'             => $catalog->category?->name,
            'city'                 => $catalog->city?->name,
            'grid_mode'            => $catalog->grid_mode ?? 'main+3',
            'main_image'           => $primaryImage?->image_path,
            'images'               => $visibleImages->map(fn ($img) => [
                                          'path' => $img->image_path,
                                      ])->values()->toArray(),
            'facilities'           => $catalog->facilities
                                          ->map(fn ($f) => ['name' => $this->clean($f->name)])
                                          ->values()->toArray(),
        ];

        foreach ($snapshotCatalog as $key => $value) {
            if (is_string($value)) {
                if (!mb_check_encoding($value, 'UTF-8')) {
                    dd('Broken field:', $key, $value);
                }
            }
        }

        Brochure::create([
            'auction_catalog_id' => $catalog->id,
            'snapshot_data' => [
                'catalog'  => $snapshotCatalog,
                'branding' => $branding,
            ],
        ]);

        // ── Slot path resolver ──
        $mainImagePath = !empty($snapshotCatalog['main_image'])
            ? public_path('storage/' . $snapshotCatalog['main_image'])
            : null;
        $mainExists = $mainImagePath && file_exists($mainImagePath);
        $allImages  = $snapshotCatalog['images'];

        $sp = function (int $idx) use ($allImages, $mainImagePath, $mainExists): ?string {
            if ($idx === 0) {
                return $mainExists ? $mainImagePath : null;
            }
            $rel = $allImages[$idx]['path'] ?? null;
            if (!$rel) return null;
            $abs = public_path('storage/' . $rel);
            return file_exists($abs) ? $abs : null;
        };

        $html = view('brochure.premium', [
            'catalog'    => $snapshotCatalog,
            'branding'   => $branding,
            'sp'         => $sp,
            'total'      => count($allImages),
            'facilities' => $snapshotCatalog['facilities'],
            'showCity'   => SystemSetting::getValue('brochure_show_city') == '1',
            'showDate'   => SystemSetting::getValue('brochure_show_date') == '1',
            'showTime'   => SystemSetting::getValue('brochure_show_time') == '1',
            'showWa'     => SystemSetting::getValue('brochure_show_wa') == '1',
            'showQr'     => SystemSetting::getValue('brochure_show_qr') == '1',
            'showFooter' => SystemSetting::getValue('brochure_show_footer') == '1',
            'tanggal'    => !empty($snapshotCatalog['auction_date'])
                                ? \Carbon\Carbon::parse($snapshotCatalog['auction_date'])->translatedFormat('d M Y')
                                : '-',
            'jam'        => !empty($snapshotCatalog['auction_time'])
                                ? substr($snapshotCatalog['auction_time'], 0, 5) . ' WIB'
                                : null,
            'wa'         => SystemSetting::getValue('contactWhatsapp'),
            'waName'     => SystemSetting::getValue('contactName'),
            'waIcon'     => $this->getWaIconBase64(),
            'qrCode'     => $this->generateQrBase64($snapshotCatalog['official_auction_url']),
        ])->render();

        // Pastikan encoding aman untuk DomPDF
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'landscape');

        return $pdf->output();
    }

    private function getWaIconBase64(): ?string
    {
        $path = public_path('images/wa.png');

        if (!file_exists($path)) {
            return null;
        }

        return 'data:image/png;base64,' . base64_encode(file_get_contents($path));
    }

    private function generateQrBase64(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        $qr = QrCode::format('png')
            ->size(160)
            ->margin(1)
            ->generate($url);

        return 'data:image/png;base64,' . base64_encode($qr);
    }

    private function clean(?string $value): ?string
    {
        if (!$value) {
            return $value;
        }

        return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
    }
}