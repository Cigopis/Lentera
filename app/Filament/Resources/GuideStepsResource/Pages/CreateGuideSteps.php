<?php

namespace App\Filament\Resources\GuideStepsResource\Pages;

use App\Filament\Resources\GuideStepsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGuideSteps extends CreateRecord
{
    protected static string $resource = GuideStepsResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        return $data;
    }

}
