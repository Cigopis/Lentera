<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogViewResource\Pages;
use App\Models\CatalogView;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CatalogViewResource extends Resource
{
    protected static ?string $model = CatalogView::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('catalog.title')
                    ->label('Catalog')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP Address')
                    ->searchable(),

                TextColumn::make('viewed_at')
                    ->label('Viewed At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('catalog_id')
                    ->relationship('catalog', 'title')
                    ->label('Filter by Catalog'),

                Filter::make('today')
                    ->label('Today')
                    ->query(fn (Builder $query) =>
                        $query->whereDate('viewed_at', now()->toDateString())
                    ),
            ])
            ->defaultSort('viewed_at', 'desc')
            ->actions([]) // tidak ada edit
            ->bulkActions([]); // tidak ada delete
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatalogViews::route('/'),
        ];
    }
}
