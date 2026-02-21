<?php

namespace App\Filament\Resources\AuctionCatalogResource\Pages;

use App\Filament\Resources\AuctionCatalogResource;
use App\Models\CatalogImage;
use Filament\Resources\Pages\CreateRecord;

class CreateAuctionCatalog extends CreateRecord
{
    protected static string $resource = AuctionCatalogResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $uploadedPaths = $this->data['catalogImages'] ?? [];

        if (empty($uploadedPaths)) {
            return;
        }

        $hasPrimary = false;

        foreach ($uploadedPaths as $path) {
            CatalogImage::create([
                'catalog_id' => $record->id,
                'image_path' => $path,
                'is_primary'  => !$hasPrimary,
            ]);

            $hasPrimary = true;
        }
    }
}