<?php

namespace App\Filament\Resources\Financial_Management\AccountResource\Pages;

use App\Filament\Resources\Financial_Management\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccount extends EditRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
