<?php

namespace App\Filament\Resources\AuctionLinkClickResource\Pages;

use App\Filament\Resources\AuctionLinkClickResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuctionLinkClick extends EditRecord
{
    protected static string $resource = AuctionLinkClickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
