<?php

namespace App\Filament\Resources\PaymentProofResource\Pages;

use App\Filament\Resources\PaymentProofResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentProof extends CreateRecord
{
    protected static string $resource = PaymentProofResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
