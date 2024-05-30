<?php

namespace App\Filament\Resources\Sales_Orders\OrderResource\Pages;

use App\Filament\Resources\Sales_Orders\OrderResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    use ExposesTableToWidgets;

    protected static string $resource = OrderResource::class;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


    protected function getHeaderWidgets(): array
    {
        return OrderResource::getWidgets();

    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'Pending' => Tab::make()->query(fn ($query) => $query->where('status', 'Pending')),
            'Confirmed' => Tab::make()->query(fn ($query) => $query->where('status', 'Confirmed')),
            'delivered' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'cancelled' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}
