<?php

namespace App\Filament\Resources\USER_AND_ROLE\CustomerResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
