<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrochureDownloadResource\Pages;
use App\Models\BrochureDownload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class BrochureDownloadResource extends Resource
{
    protected static ?string $model = BrochureDownload::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationGroup = 'Analytics';
    protected static ?int $navigationSort = 2;

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

                TextColumn::make('downloaded_at')
                    ->label('Downloaded At')
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
                        $query->whereDate('downloaded_at', now()->toDateString())
                    ),
            ])
            ->defaultSort('downloaded_at', 'desc')
            ->actions([])     
            ->bulkActions([]); 
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrochureDownloads::route('/'),
        ];
    }
}
