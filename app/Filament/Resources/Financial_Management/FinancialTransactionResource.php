<?php

namespace App\Filament\Resources\Financial_Management;

use Andreia\FilamentStripePaymentLink\Forms\Actions\GenerateStripeLinkAction;
use App\Filament\Resources\FinancialTransactionResource\Pages;
use App\Filament\Resources\FinancialTransactionResource\RelationManagers;
use App\Models\FinancialTransaction;
use App\Models\Order;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_IH_Order_QB;

class FinancialTransactionResource extends Resource
{
    protected static ?string $model = FinancialTransaction::class;
    protected static ?string $navigationGroup = 'Financial Management';

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('transaction_date'),

                Forms\Components\Select::make('vendor_id')
                    ->relationship('payment.vendor', 'business_name')
                ->label('vedor')
//                    ->required(),
        ,
                Forms\Components\TextInput::make('rip')

                ->required(),

                TextInput::make('stripe_payment_link')
                    ->required()
                    ->suffixAction(GenerateStripeLinkAction::make('stripe_payment_link')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_date')
                    ->dateTime()
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment.vendor.business_name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getQuery(): Builder|_IH_Order_QB
    {
        return Payment::with([ 'vendor.personalInfo']);
    }


    public static function getPages(): array
    {
        return [
            'index' => FinancialTransactionResource\Pages\ListFinancialTransactions::route('/'),
            'create' => FinancialTransactionResource\Pages\CreateFinancialTransaction::route('/create'),
            'edit' => FinancialTransactionResource\Pages\EditFinancialTransaction::route('/{record}/edit'),
        ];
    }
}
