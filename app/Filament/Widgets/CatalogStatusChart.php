<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\AuctionCatalog;

class CatalogStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Catalog';

    
    protected static ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 8, // sesuaikan
    ];


    protected function getData(): array
    {
        $draft = AuctionCatalog::where('status', 'draft')->count();
        $active = AuctionCatalog::where('status', 'active')->count();
        $closed = AuctionCatalog::where('status', 'closed')->count();

        $total = $draft + $active + $closed;

        // Kalau semua 0, kasih dummy 1 supaya donut tetap bulat
        if ($total === 0) {
            return [
                'datasets' => [
                    [
                        'data' => [1], // 🔥 PENTING: [1] bukan [$draft, $active, $closed]
                        'backgroundColor' => ['#E5E7EB'],
                        'borderWidth' => 0,
                    ],
                ],
                'labels' => ['No Data Available'],
            ];
        }

        // Return data yang benar dengan backgroundColor
        return [
            'datasets' => [
                [
                    'data' => [$draft, $active, $closed],
                    'backgroundColor' => [ // 🔥 INI HILANG DI KODE KAMU
                        '#F59E0B', // draft (amber)
                        '#10B981', // active (green)
                        '#EF4444', // closed (red)
                    ],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => ['Draft', 'Active', 'Closed'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'cutout' => '65%', // 🔥 Untuk donut effect
            'maintainAspectRatio' => true,
            'aspectRatio' => 1.3, // 🔥 Ratio lebar:tinggi
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                        'padding' => 15,
                        'font' => [
                            'size' => 12,
                        ],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => '#111827',
                    'padding' => 10,
                    'titleFont' => ['size' => 13],
                    'bodyFont' => ['size' => 12],
                ],
            ],
        ];
    }


}
