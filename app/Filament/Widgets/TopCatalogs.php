<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget;
use App\Models\AuctionCatalog;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class TopCatalogs extends TableWidget
{
    protected static ?string $heading = 'Top 5 Catalog Views';
    protected static ?string $maxHeight = '320px';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 8, 
    ];


    protected function getTableQuery(): Builder
    {
        return AuctionCatalog::query()
            ->withCount('views')
            ->orderByDesc('views_count')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')->limit(40),
            Tables\Columns\TextColumn::make('views_count')
                ->label('Total Views'),
        ];
    }
}
