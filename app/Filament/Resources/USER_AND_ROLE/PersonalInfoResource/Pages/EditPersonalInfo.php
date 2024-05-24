<?php

namespace App\Filament\Resources\USER_AND_ROLE\PersonalInfoResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\PersonalInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersonalInfo extends EditRecord
{
    protected static string $resource = PersonalInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
