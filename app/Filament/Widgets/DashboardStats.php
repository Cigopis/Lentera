<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\AuctionCatalog;
use App\Models\CatalogView;
use App\Models\BrochureDownload;
use App\Models\AuctionLinkClick;
use Carbon\Carbon;

class DashboardStats extends BaseWidget
{
    protected static ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 8, // sesuaikan
    ];

    
    protected function getCards(): array
    {
        $totalViews = CatalogView::count();
        $totalDownload = BrochureDownload::count();

        $conversion = $totalViews > 0
            ? round(($totalDownload / $totalViews) * 100, 2)
            : 0;

        return [

            Card::make('Total Catalog', AuctionCatalog::count())
                ->color('primary'),

            Card::make('Active Catalog',
                AuctionCatalog::where('status', 'active')->count()
            )
                ->color('success'),

            Card::make('Closing Soon',
                AuctionCatalog::whereDate('auction_date', Carbon::today())
                    ->orWhereDate('auction_date', Carbon::tomorrow())
                    ->count()
            )
                ->color('danger'),

            Card::make('Total Views', $totalViews)
                ->color('info'),

            Card::make('Total Download', $totalDownload)
                ->color('warning'),

            Card::make('Conversion Rate', $conversion . '%')
                ->description('Download / Views')
                ->color('gray'),
        ];
    }
}
