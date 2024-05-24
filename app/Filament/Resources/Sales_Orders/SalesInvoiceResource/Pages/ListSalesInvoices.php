<?php

namespace App\Filament\Resources\Sales_Orders\SalesInvoiceResource\Pages;

use App\Filament\Resources\Sales_Orders\SalesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesInvoices extends ListRecords
{
    protected static string $resource = SalesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
