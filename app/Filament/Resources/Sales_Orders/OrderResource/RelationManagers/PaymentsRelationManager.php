<?php

namespace App\Filament\Resources\Sales_Orders\OrderResource\RelationManagers;

use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'reference';

    public function form(Form $form): Form
    {
        return $form
            ->schema([


                DatePicker::make('payment_date')
                    ->required(),

                Select::make('vendor_id')
                    ->relationship('vendor', 'business_name')
                    ->required(),

                ToggleButtons::make('provider')
                    ->inline()
                    ->grouped()
                    ->options([
                        'CIH' => 'CIH',
                        'paypal' => 'PayPal',
                        'Stripe' => 'STRIPE',
                    ])
                    ->reactive()
                    ->required(),

                ToggleButtons::make('calculate the total amount')
                    ->inline()
                    ->options(Order::query()->pluck('type', 'id')->map(fn ($value) => 'calculate 🖩')->take(1))
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('amount', Order::find($state)?->total_price ?? 0))
                    ->distinct()
                    ->live(),

                ToggleButtons::make('method')
                    ->options(fn (callable $get) => $this->getPaymentMethods($get('provider')))
                    ->reactive()
                    ->required(),

                TextInput::make('amount')
                    ->numeric()
                    ->required()
            ])->columns(2);
    }

    protected function getPaymentMethods($provider): array
    {
        $methods = [
            'CIH' => ['Bank Transfer' => 'Bank Transfer'],
            'paypal' => ['PayPal Account' => 'PayPal Account'],
            'Stripe' => ['Bank Transfer' => 'Bank Transfer'],
        ];

        return $methods[$provider] ?? [];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColumnGroup::make('Details')
                    ->columns([


                        Tables\Columns\TextColumn::make('amount')
                            ->sortable()
                            ->money("usd"),
                    ]),

                Tables\Columns\ColumnGroup::make('Context')
                    ->columns([
                        Tables\Columns\TextColumn::make('provider')
                            ->formatStateUsing(fn ($state) => Str::headline($state))
                            ->sortable(),

                        Tables\Columns\TextColumn::make('method')
                            ->formatStateUsing(fn ($state) => Str::headline($state))
                            ->sortable(),
                    ]),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
