<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEvent extends CreateRecord
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static string $resource = EventResource::class;
}
