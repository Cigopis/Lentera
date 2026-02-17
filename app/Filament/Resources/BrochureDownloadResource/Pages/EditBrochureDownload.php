<?php

namespace App\Filament\Resources\BrochureDownloadResource\Pages;

use App\Filament\Resources\BrochureDownloadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrochureDownload extends EditRecord
{
    protected static string $resource = BrochureDownloadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
