<?php

namespace App\Filament\Resources\GuideStepsResource\Pages;

use App\Filament\Resources\GuideStepsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuideSteps extends ListRecords
{
    protected static string $resource = GuideStepsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
