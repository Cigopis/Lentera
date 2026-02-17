<?php

namespace App\Filament\Resources\AuctionLinkClickResource\Pages;

use App\Filament\Resources\AuctionLinkClickResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuctionLinkClicks extends ListRecords
{
    protected static string $resource = AuctionLinkClickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
