<?php

namespace App\Filament\Resources\SupplierRatingResource\Pages;

use App\Filament\Resources\SupplierRatingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplierRating extends EditRecord
{
    protected static string $resource = SupplierRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
