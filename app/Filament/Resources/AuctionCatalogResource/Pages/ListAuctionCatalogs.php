<?php

namespace App\Filament\Resources\AuctionCatalogResource\Pages;

use App\Filament\Resources\AuctionCatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuctionCatalogs extends ListRecords
{
    protected static string $resource = AuctionCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
