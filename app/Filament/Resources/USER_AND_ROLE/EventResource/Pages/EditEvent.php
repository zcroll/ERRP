<?php

namespace App\Filament\Resources\USER_AND_ROLE\EventResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
