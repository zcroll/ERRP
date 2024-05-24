<?php

namespace App\Filament\Resources\Products_Inventory\VendorResource\Pages;

use App\Filament\Resources\Products_Inventory\VendorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendors extends ListRecords
{
    protected static string $resource = VendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
