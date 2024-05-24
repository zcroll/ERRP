<?php

namespace App\Filament\Resources\Sales_Orders\SalesInvoiceResource\Pages;

use App\Filament\Resources\Sales_Orders\SalesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesInvoice extends EditRecord
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
