<?php

namespace App\Filament\Resources\Products_Inventory\VendorResource\Pages;

use App\Filament\Resources\Products_Inventory\VendorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVendor extends EditRecord
{
    protected static string $resource = VendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
