<?php

namespace App\Filament\Resources\Sales_Orders\OrderItemResource\Pages;

use App\Filament\Resources\Sales_Orders\OrderItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderItem extends EditRecord
{
    protected static string $resource = OrderItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
