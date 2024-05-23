<?php

namespace App\Filament\Resources\ProductDimensionResource\Pages;

use App\Filament\Resources\ProductDimensionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductDimension extends EditRecord
{
    protected static string $resource = ProductDimensionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
