<?php

namespace App\Filament\Resources\AuctionCatalogResource\Pages;

use App\Filament\Resources\AuctionCatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuctionCatalog extends EditRecord
{
    protected static string $resource = AuctionCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
