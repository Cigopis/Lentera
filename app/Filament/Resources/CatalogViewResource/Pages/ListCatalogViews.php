<?php

namespace App\Filament\Resources\CatalogViewResource\Pages;

use App\Filament\Resources\CatalogViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatalogViews extends ListRecords
{
    protected static string $resource = CatalogViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
