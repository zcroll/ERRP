<?php

namespace App\Filament\Resources\Products_Inventory;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;
    protected static ?string $navigationGroup = "Products & Inventory";

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vendor_code')
                    ->required(),
                Forms\Components\TextInput::make('business_name')
                    ->required(),
                Forms\Components\Select::make('supplier_type_id')
                    ->relationship('supplierType', 'id')
                    ->required(),
                Forms\Components\TextInput::make('supplier_rating_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('address_id')
                    ->relationship('address', 'id')
                    ->required(),
                Forms\Components\Select::make('personal_info_id')
                    ->relationship('personalInfo', 'id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('supplierType.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('supplier_rating_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('personalInfo.id')
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

    public static function getPages(): array
    {
        return [
            'index' => VendorResource\Pages\ListVendors::route('/'),
            'create' => VendorResource\Pages\CreateVendor::route('/create'),
            'edit' => VendorResource\Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
