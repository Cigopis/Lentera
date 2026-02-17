<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuctionLinkClickResource\Pages;
use App\Models\AuctionLinkClick;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class AuctionLinkClickResource extends Resource
{
    protected static ?string $model = AuctionLinkClick::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-rays';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?int $navigationSort = 3;

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

                TextColumn::make('clicked_at')
                    ->label('Clicked At')
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
                        $query->whereDate('clicked_at', now()->toDateString())
                    ),
            ])
            ->defaultSort('clicked_at', 'desc')
            ->actions([])      // tidak bisa edit
            ->bulkActions([]); // tidak bisa delete
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAuctionLinkClicks::route('/'),
        ];
    }
}
