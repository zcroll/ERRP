<?php

namespace App\Filament\Resources\Sales_Orders\EarningsLossesResource\Pages;

use App\Filament\Resources\Sales_Orders\EarningsLossesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEarningsLosses extends EditRecord
{
    protected static string $resource = EarningsLossesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
