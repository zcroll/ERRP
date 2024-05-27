<?php

namespace App\Filament\Resources\Products_Inventory;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
//use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = "Products & Inventory";


    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_code')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('unit_price')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('is_discontinued')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->required(),
                Forms\Components\Select::make('product_category_id')
                    ->relationship('productCategory', 'category_name')
                    ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_discontinued')
                    ->boolean(),
                Tables\Columns\TextColumn::make('productCategory.name')
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
                Tables\Actions\ViewAction::make(),            ])
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

    public static function infoList(Infolist $infoList): InfoList
    {
        return $infoList
            ->schema([
                Components\Section::make()
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(4)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('product_code'),
                                        Components\TextEntry::make('name'),
                                        Components\TextEntry::make('unit_price')
                                        ->badge(),
                                        Components\TextEntry::make('is_discontinued')
                                            ->badge()
                                            ->getStateUsing(fn (Product $record): string => $record->is_discontinued ? 'true' : 'false')

                                            ->colors([
                                                'success' => 'true',
                                                'danger' => 'false',
                                            ]),                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('productCategory.category_name'),
                                    ]),
                                ]),
                            Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from(''),
                    ]),
                Components\Section::make('Description')
                    ->schema([
                        Components\TextEntry::make('description')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
//            ProductResource\Pages\CreateProduct::class,
            ProductResource\Pages\ViewProduct::class,
            ProductResource\Pages\EditProduct::class
        ]);
    }
    public static function getPages(): array
    {
        return [

            'create' => ProductResource\Pages\CreateProduct::route('/create'),
            'index' => ProductResource\Pages\ListProducts::route('/'),
            'view' => ProductResource\Pages\ViewProduct::route('/{record}'),
            'edit' => ProductResource\Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
