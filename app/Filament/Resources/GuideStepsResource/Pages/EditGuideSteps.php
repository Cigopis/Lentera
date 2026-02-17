<?php

namespace App\Filament\Resources\GuideStepsResource\Pages;

use App\Filament\Resources\GuideStepsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuideSteps extends EditRecord
{
    protected static string $resource = GuideStepsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
