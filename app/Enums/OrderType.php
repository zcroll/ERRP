<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderType: string implements HasColor, HasIcon, HasLabel
{
    case Sale = 'sale';

    case Purchase = 'purchase';

    public function getLabel(): string
    {
        return match ($this) {
            self::Sale => 'Sale',
            self::Purchase => 'Purchase',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Sale => 'info',
            self::Purchase => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Sale => 'heroicon-m-sparkles',
            self::Purchase => 'heroicon-m-arrow-path',
        };
    }
}
