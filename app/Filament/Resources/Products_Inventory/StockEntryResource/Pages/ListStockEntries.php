<?php

namespace App\Filament\Resources\Products_Inventory\StockEntryResource\Pages;

use App\Filament\Resources\Products_Inventory\StockEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockEntries extends ListRecords
{
    protected static string $resource = StockEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
