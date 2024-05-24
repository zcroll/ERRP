<?php

namespace App\Filament\Resources\Financial_Management\PurchaseInvoiceResource\Pages;

use App\Filament\Resources\Financial_Management\PurchaseInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseInvoices extends ListRecords
{
    protected static string $resource = PurchaseInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
