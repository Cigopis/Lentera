<?php

namespace App\Filament\Resources\BrochureDownloadResource\Pages;

use App\Filament\Resources\BrochureDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrochureDownloads extends ListRecords
{
    protected static string $resource = BrochureDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
