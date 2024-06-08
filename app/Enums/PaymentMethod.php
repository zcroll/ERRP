<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasColor, HasIcon, HasLabel
{
    case CreditCard = 'credit_card';
    case PayPal = 'paypal';
    case BankTransfer = 'bank_transfer';
    case CashOnDelivery = 'cash_on_delivery';
    case Cryptocurrency = 'cryptocurrency';
    case GiftCard = 'gift_card';

    public function getLabel(): string
    {
        return match ($this) {
            self::CreditCard => 'Credit Card',
            self::PayPal => 'PayPal',
            self::BankTransfer => 'Bank Transfer',
            self::CashOnDelivery => 'Cash on Delivery',
            self::Cryptocurrency => 'Cryptocurrency',
            self::GiftCard => 'Gift Card',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::CreditCard => 'primary',
            self::PayPal => 'info',
            self::BankTransfer => 'secondary',
            self::CashOnDelivery => 'success',
            self::Cryptocurrency => 'warning',
            self::GiftCard => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::CreditCard, self::PayPal, self::BankTransfer, self::CashOnDelivery, self::Cryptocurrency, self::GiftCard => 'heroicon-m-credit-card',
        };
    }
}
