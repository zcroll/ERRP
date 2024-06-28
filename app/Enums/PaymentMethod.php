<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasColor, HasIcon, HasLabel
{
    case CreditCard = 'credit_card';
    case BankTransfer = 'bank_transfer';
    case CashOnDelivery = 'cash_on_delivery';

    public function getLabel(): string
    {
        return match ($this) {
            self::CreditCard => 'Credit Card',
            self::BankTransfer => 'Bank Transfer',
            self::CashOnDelivery => 'Cash on Delivery',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CreditCard => 'primary',
            self::BankTransfer => 'secondary',
            self::CashOnDelivery => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CreditCard,self::BankTransfer, self::CashOnDelivery, => 'heroicon-m-credit-card',
        };
    }
}
