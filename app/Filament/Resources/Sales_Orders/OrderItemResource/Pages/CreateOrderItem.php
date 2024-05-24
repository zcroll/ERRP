<?php

namespace App\Filament\Resources\Sales_Orders\OrderItemResource\Pages;

use App\Filament\Resources\Sales_Orders\OrderItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderItem extends CreateRecord
{
    protected static string $resource = OrderItemResource::class;
}
