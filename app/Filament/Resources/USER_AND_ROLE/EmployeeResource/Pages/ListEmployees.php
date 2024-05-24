<?php

namespace App\Filament\Resources\USER_AND_ROLE\EmployeeResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
