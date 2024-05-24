<?php

namespace App\Filament\Resources\Financial_Management\PaymentResource\Pages;

use App\Filament\Resources\Financial_Management\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
