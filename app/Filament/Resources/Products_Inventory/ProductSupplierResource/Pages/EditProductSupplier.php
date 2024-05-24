<?php

namespace App\Filament\Resources\Products_Inventory\ProductSupplierResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductSupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductSupplier extends EditRecord
{
    protected static string $resource = ProductSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
