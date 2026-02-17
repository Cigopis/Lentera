<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\CatalogView;
use Carbon\Carbon;

class ViewsChart extends ChartWidget
{
    protected static ?string $heading = 'Views 7 Hari Terakhir';
    protected static ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 8,
    ];


    protected function getData(): array
    {
        $data = collect(range(6, 0))->map(function ($day) {
            return CatalogView::whereDate('viewed_at', Carbon::today()->subDays($day))
                ->count();
        });

        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => $data,
                ],
            ],
            'labels' => collect(range(6, 0))->map(function ($day) {
                return Carbon::today()->subDays($day)->format('d M');
            }),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
