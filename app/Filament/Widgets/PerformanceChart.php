<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CatalogView;
use App\Models\BrochureDownload;
use Carbon\Carbon;

class PerformanceChart extends ChartWidget
{
    protected static ?string $heading = 'Performance 30 Hari Terakhir';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 8,
    ];

    protected static ?string $maxHeight = '300px';


    protected function getData(): array
    {
        $views = [];
        $downloads = [];
        $labels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $labels[] = $date->format('d M');

            $views[] = CatalogView::whereDate('viewed_at', $date)->count();
            $downloads[] = BrochureDownload::whereDate('downloaded_at', $date)->count();
        }

        return [
            [
                'label' => 'Views',
                'data' => $views,
                'borderColor' => '#6366F1',
                'backgroundColor' => 'rgba(99,102,241,0.1)',
            ],
            [
                'label' => 'Downloads',
                'data' => $downloads,
                'borderColor' => '#10B981',
                'backgroundColor' => 'rgba(16,185,129,0.1)',
            ],

            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
            ],
            'elements' => [
                'line' => [
                    'tension' => 0.4, // smooth curve
                    'borderWidth' => 3,
                ],
                'point' => [
                    'radius' => 4,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(0,0,0,0.05)',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }

}
