<?php

namespace App\Filament\Resources\Products_Inventory\ProductCategoryResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductCategory extends EditRecord
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
