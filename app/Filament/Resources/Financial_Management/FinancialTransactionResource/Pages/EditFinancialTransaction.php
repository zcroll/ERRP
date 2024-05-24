<?php

namespace App\Filament\Resources\Financial_Management\FinancialTransactionResource\Pages;

use App\Filament\Resources\Financial_Management\FinancialTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinancialTransaction extends EditRecord
{
    protected static string $resource = FinancialTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
