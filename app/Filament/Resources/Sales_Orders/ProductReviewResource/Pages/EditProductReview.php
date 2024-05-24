<?php

namespace App\Filament\Resources\Sales_Orders\ProductReviewResource\Pages;

use App\Filament\Resources\Sales_Orders\ProductReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductReview extends EditRecord
{
    protected static string $resource = ProductReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
