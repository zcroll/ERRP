<?php

namespace App\Filament\Resources\USER_AND_ROLE\CustomerResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
