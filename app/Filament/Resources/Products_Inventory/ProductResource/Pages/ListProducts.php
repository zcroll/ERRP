<?php

namespace App\Filament\Resources\Products_Inventory\ProductResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
