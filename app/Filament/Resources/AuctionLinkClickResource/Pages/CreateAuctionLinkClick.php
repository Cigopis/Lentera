<?php

namespace App\Filament\Resources\AuctionLinkClickResource\Pages;

use App\Filament\Resources\AuctionLinkClickResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuctionLinkClick extends CreateRecord
{
    protected static string $resource = AuctionLinkClickResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}