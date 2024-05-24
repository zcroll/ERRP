<?php

namespace App\Filament\Resources\Products_Inventory\ProductCategoryResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductCategories extends ListRecords
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
