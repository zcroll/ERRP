<?php

namespace App\Filament\Resources\Products_Inventory\ProductResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
