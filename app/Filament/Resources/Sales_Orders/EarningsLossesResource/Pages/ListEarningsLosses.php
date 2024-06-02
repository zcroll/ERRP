<?php

namespace App\Filament\Resources\Sales_Orders\EarningsLossesResource\Pages;

use App\Filament\Resources\Sales_Orders\EarningsLossesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEarningsLosses extends ListRecords
{
    protected static string $resource = EarningsLossesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
