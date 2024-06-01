<?php

namespace App\Filament\Resources\Products_Inventory;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

//use Filament\Pages\Page;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = "Products & Inventory";


    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;
//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('product_code')
                    ->required(),
                        Forms\Components\TextInput::make('name')
                            ->required(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->required()
                            ->columnSpanFull(),


                    ])
                    ->columns(2),
                Forms\Components\Card::make('Status & Category')
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_visible')
                                    ->label('Visible')
                                    ->helperText('This product will be hidden from all sales channels.')
                                    ->default(true),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Availability')
                                    ->default(now())
                                    ->required(),


                                Forms\Components\Select::make('product_category_id')
                                    ->relationship('productCategory', 'category_name')
                                    ->required(),
                            ])->columns(2),
                    ])->collapsed(),
                forms\Components\Section::make('Images')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->multiple()
                            ->maxFiles(5)
                            ->disableLabel(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('unit_price')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),

                        Forms\Components\TextInput::make('old_price')
                            ->label('Compare at price')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),

                        Forms\Components\TextInput::make('cost')
                            ->label('Cost per item')
                            ->helperText('Customers won\'t see this price.')
                            ->numeric()
                            ->rules(['regex:/^\d{1,6}(\.\d{0,2})?$/'])
                            ->required(),
                    ])
                    ->columns(2)
                    ->collapsed(),

                Forms\Components\Section::make('Inventory')
                    ->schema([
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU (Stock Keeping Unit)')
                            ->unique(Product::class, 'sku', ignoreRecord: true)
                            ->required(),

                        Forms\Components\TextInput::make('barcode')
                            ->label('Barcode (ISBN, UPC, GTIN, etc.)')
                            ->unique(Product::class, 'barcode', ignoreRecord: true)
                            ->required(),

                        Forms\Components\TextInput::make('qty')
                            ->label('Quantity')
                            ->numeric()
                            ->rules(['integer', 'min:0'])
                            ->required(),

                        Forms\Components\TextInput::make('security_stock')
                            ->helperText('The safety stock is the limit stock for your products which alerts you if the product stock will soon be out of stock.')
                            ->numeric()
                            ->rules(['integer', 'min:0'])
                            ->required(),
                    ])
                    ->collapsed()
                    ->columns(2),
                Forms\Components\Section::make('Shipping')
                    ->schema([
                        Forms\Components\Checkbox::make('backorder')
                            ->label('This product can be returned'),

                        Forms\Components\Checkbox::make('requires_shipping')
                            ->label('This product will be shipped'),
                    ])
                    ->collapsed()
                    ->columns(2),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->label('Image')
                    ->collection('product-images'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Price')
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('productCategory.category_name')
                    ->numeric()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qty')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('security_stock')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\BooleanColumn::make('is_visible')
                    ->label('Visibility')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publish Date')
                    ->date()
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),

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
                                ->columnSpanFull()
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
            ProductResource\Pages\EditProduct::class,
            ProductResource\Pages\ManageProductDimensions::class,
            ProductResource\Pages\ManageProductSuppliers::class,
            ProductResource\Pages\ProductReviews::class
        ]);
    }
    public static function getPages(): array
    {
        return [

            'create' => ProductResource\Pages\CreateProduct::route('/create'),
            'dimension' => ProductResource\Pages\ManageProductDimensions::route('/{record}/demension'),
            'suplier' => ProductResource\Pages\ManageProductSuppliers::route('/{record}/suplier'),
            'rating' => ProductResource\Pages\ProductReviews::route('/{record}/rating'),
            'index' => ProductResource\Pages\ListProducts::route('/'),
            'view' => ProductResource\Pages\ViewProduct::route('/{record}'),
            'edit' => ProductResource\Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
