<?php

namespace App\Filament\Resources\Products_Inventory\ProductDimensionResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductDimensionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductDimensions extends ListRecords
{
    protected static string $resource = ProductDimensionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
