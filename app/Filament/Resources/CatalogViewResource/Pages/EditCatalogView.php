<?php

namespace App\Filament\Resources\CatalogViewResource\Pages;

use App\Filament\Resources\CatalogViewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatalogView extends EditRecord
{
    protected static string $resource = CatalogViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
