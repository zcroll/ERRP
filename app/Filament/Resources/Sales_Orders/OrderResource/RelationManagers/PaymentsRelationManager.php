<?php

namespace App\Filament\Resources\Sales_Orders\OrderResource\RelationManagers;

use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Filament\Forms;
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
                Forms\Components\TextInput::make('reference')
                    ->columnSpan('full')
                    ->required(),



                Forms\Components\DatePicker::make('payment_date')
                    ->required(),

                Forms\Components\ToggleButtons::make('provider')
                    ->inline()
                    ->grouped()
                    ->options([
                        'CIH' => 'CIH',
                        'paypal' => 'PayPal',
                        'CHECK' => 'Check',
                    ])
                    ->required(),

                Forms\Components\ToggleButtons::make('calculate the price')
                    ->inline()
                    ->options(Order::query()->pluck('type', 'id'))
                    ->reactive()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('amount', Order::find($state)?->total_price ?? 0 ))
                    ->distinct()
                    ->live(),


                Forms\Components\ToggleButtons::make('method')
                        ->options(PaymentMethod::class)
                         ->inline()


                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                ->required()
            ])->columns(2);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColumnGroup::make('Details')
                    ->columns([
                        Tables\Columns\TextColumn::make('reference')
                            ->searchable(),

                        Tables\Columns\TextColumn::make('amount')
                            ->sortable()
                            ->money(fn ($record) => $record->currency),
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
