<?php

namespace App\Filament\Resources\Financial_Management\PurchaseInvoiceResource\Pages;

use App\Filament\Resources\Financial_Management\PurchaseInvoiceResource;
use App\Models\PurchaseInvoice;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class PreviewPurchaseInvoice extends ViewRecord
{
    protected static string $resource = PurchaseInvoiceResource::class;

    public function getTitle(): string|Htmlable
    {
        /** @var PurchaseInvoice $record */
        $record = $this->getRecord();

        return $record->invoice_number;
    }

    protected function getActions(): array
    {
        return [];
    }
}
