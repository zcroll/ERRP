<?php

namespace App\Filament\Resources\SupplierRatingResource\Pages;

use App\Filament\Resources\SupplierRatingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierRatings extends ListRecords
{
    protected static string $resource = SupplierRatingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
