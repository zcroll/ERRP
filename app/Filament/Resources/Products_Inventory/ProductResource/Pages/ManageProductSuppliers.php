<?php

namespace App\Filament\Resources\Products_Inventory\ProductResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductResource;
use Filament\Forms;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Illuminate\Contracts\Support\Htmlable;

class ManageProductSuppliers extends ManageRelatedRecords
{
    protected static string $resource = ProductResource::class;
    protected static string $relationship = 'productSupplier';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public function getTitle(): string | Htmlable
    {
        $recordTitle = $this->getRecordTitle();
        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;
        return "Manage {$recordTitle} Product Suppliers";
    }

    public function getBreadcrumb(): string
    {
        return 'ProductSuppliers';
    }

    public static function getNavigationLabel(): string
    {
        return 'Manage Product Suppliers';
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\BelongsToSelect::make('vendor_id')->relationship('vendor', 'business_name')->searchable()->required(),
                Forms\Components\TextInput::make('quantity')->required(),
                Forms\Components\TextInput::make('purchase_price')->required()->placeholder('0.00')->numeric(),
            ])
            ->columns(1);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('vendor.name')->label('Vendor')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('quantity')->label('Quantity')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('purchase_price')->label('Purchase Price')->searchable()->sortable(),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
