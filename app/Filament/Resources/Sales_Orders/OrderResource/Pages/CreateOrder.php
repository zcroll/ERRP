<?php

namespace App\Filament\Resources\Sales_Orders\OrderResource\Pages;

use App\Filament\Resources\Sales_Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
