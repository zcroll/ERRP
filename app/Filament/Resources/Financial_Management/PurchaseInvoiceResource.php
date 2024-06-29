<?php

namespace App\Filament\Resources\Financial_Management;

use App\Models\PurchaseInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PurchaseInvoiceResource extends Resource
{
    protected static ?string $model = PurchaseInvoice::class;
    protected static ?string $navigationGroup = 'Financial Management';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('invoice_date')
                    ->required(),
                Forms\Components\TextInput::make('invoice_number')
                    ->required(),

                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\Select::make('vendor_id')
                    ->relationship('vendor', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order.total_price')
                    ->label('Total Price')

                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('vendor.business_name')
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

                        Tables\Actions\ViewAction::make(),
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
    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;

        return (string) $modelClass::where('status', 'pending')->count();
    }
//    public static function getRecordSubNavigation(Page $page): array
//    {
//        return $page->generateNavigationItems([
//            PurchaseInvoiceResource\Pages\PreviewPurchaseInvoice::class,
//            // Add dimensions and suppliers
//
//        ]);
//    }

    public static function getPages(): array
    {
        return [

            'index' => PurchaseInvoiceResource\Pages\ListPurchaseInvoices::route('/'),
            'edit'  => PurchaseInvoiceResource\Pages\EditPurchaseInvoice::route('/{record}/edit'),
            // Add other necessary routes
        ];
    }
}
