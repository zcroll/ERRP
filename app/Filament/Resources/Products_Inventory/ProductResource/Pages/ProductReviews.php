<?php

namespace App\Filament\Resources\Products_Inventory\ProductResource\Pages;


use App\Filament\Resources\Products_Inventory\ProductResource;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentRatingStar\Columns\RatingStarColumn;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_IH_Order_QB;

class ProductReviews extends ManageRelatedRecords
{
    protected static string $resource = ProductResource::class;
    protected static string $relationship = 'productReviews';
    protected static ?string $navigationIcon = 'heroicon-o-star';

    public static function getNavigationLabel(): string
    {
        return 'Manage Product Reviews';
    }

    public static function getQuery(): Builder|_IH_Order_QB
    {
        return Product::with(['customer.personalInfo']);
    }

    public function getTitle(): string|Htmlable
    {
        $recordTitle = $this->getRecordTitle();
        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;
        return "Manage {$recordTitle} Product Reviews";
    }

    public function getBreadcrumb(): string
    {
        return 'ProductReviews';
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                RatingStarColumn::make('rating')
                    ->label('Rating'),

                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                RatingStarColumn::make('rating')
                    ->label('Rating')
                    ->searchable()
                    ->sortable(),
                Columns\TextColumn::make('customer.personalInfo.first_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
            ]);

    }
}
