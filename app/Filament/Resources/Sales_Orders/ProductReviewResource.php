<?php

namespace App\Filament\Resources\Sales_Orders;

use App\Models\Order;
use App\Models\ProductReview;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use IbrahimBougaoua\FilamentRatingStar\Actions\RatingStar;
use IbrahimBougaoua\FilamentRatingStar\Columns\RatingStarColumn;
use Illuminate\Database\Eloquent\Builder;
use LaravelIdea\Helper\App\Models\_IH_Order_QB;

class ProductReviewResource extends Resource
{
    protected static ?string $model = ProductReview::class;
    protected static ?string $navigationGroup = 'Sales & Orders';

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
                Select::make('customer_id')
                    ->relationship('customer.personalInfo', 'first_name')
                    ->reactive()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->required(),

                Section::make()
                    ->schema([
                        RatingStar::make('rating')
                            ->label('Rating')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                RatingStarColumn::make('rating')
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.personalInfo.first_name')
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
    public static function getNavigationBadge(): ?string
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::$model;
        $weekStart = now()->startOfWeek();

        return (string) $modelClass::where('created_at', '>=', $weekStart)->where('rating')->count();
    }
    public static function getQuery(): Builder|_IH_Order_QB
    {
        return Order::with(['customer.personalInfo']);
    }
    public static function getPages(): array
    {
        return [
            'index' => ProductReviewResource\Pages\ListProductReviews::route('/'),
            'create' => ProductReviewResource\Pages\CreateProductReview::route('/create'),
            'edit' => ProductReviewResource\Pages\EditProductReview::route('/{record}/edit'),
        ];
    }
}
