<?php

namespace App\Filament\Resources\USER_AND_ROLE\EventResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\EventResource;
use App\Filament\Resources\USER_AND_ROLE\EventResource\Widgets\CalendarWidget;
use Filament\Resources\Pages\ListRecords;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;


    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}
