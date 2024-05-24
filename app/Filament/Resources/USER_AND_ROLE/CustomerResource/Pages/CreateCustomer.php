<?php

namespace App\Filament\Resources\USER_AND_ROLE\CustomerResource\Pages;

use App\Filament\Resources\USER_AND_ROLE\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
