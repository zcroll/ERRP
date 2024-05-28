<?php

namespace App\Filament\Resources\Products_Inventory\ProductResource\Pages;

use App\Filament\Resources\Products_Inventory\ProductResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class ManageProductDimensions extends ManageRelatedRecords
{
    protected static string $resource = ProductResource::class;
    protected static string $relationship = 'productDimension';
    protected static ?string $navigationIcon = 'heroicon-o-cube-transparent';

    public function getTitle(): string | Htmlable
    {
        $recordTitle = $this->getRecordTitle();
        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;
        return "Manage {$recordTitle} Product Dimensions";
    }

    public function getBreadcrumb(): string
    {
        return 'ProductDimensions';
    }

    public static function getNavigationLabel(): string
    {
        return 'Manage Product Dimensions';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\MarkdownEditor::make('dimensions')
                    ->required()
                    ->label('Dimensions')
                    ->placeholder("Format: \n- Dimension1\n- Dimension2\n- Dimension3")->required(),
                Forms\Components\Select::make('product_id')->relationship('product', 'name')->searchable()->required(),
                Forms\Components\Toggle::make('weight')->label('Weight')->default(true),
                Forms\Components\MarkdownEditor::make('weight_unit')->required()->label('Weight Unit'),


        ])
        ->columns(1);
    }

    public function infoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('dimensions'),
                TextEntry::make('product.name'),
                TextEntry::make('weight')->label('Weight'),
                TextEntry::make('weight_unit'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('dimensions')
            ->columns([
                Tables\Columns\TextColumn::make('dimensions')->label('Dimensions')->badge()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('product.name')->label('Product')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('weight')->label('Weight')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('weight_unit')->label('Weight Unit')->searchable()->sortable(),
            ])
            ->filters([])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->groupedBulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }
}
