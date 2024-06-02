<?php

namespace App\Filament\Resources\Sales_Orders;

use App\Filament\Resources\EarningsLossesResource\Pages;
use App\Filament\Resources\EarningsLossesResource\RelationManagers;
use App\Models\EarningsLosses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EarningsLossesResource extends Resource
{
    protected static ?string $model = EarningsLosses::class;

//    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Sales & Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'number')
                    ->required(),
                Forms\Components\TextInput::make('earnings')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('losses')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('earnings')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money(),
                    ])
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('losses')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('EUR'),
                    ])
                    ->numeric(),
                Tables\Columns\TextColumn::make('total')

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
            'index' => EarningsLossesResource\Pages\ListEarningsLosses::route('/'),
            'create' => EarningsLossesResource\Pages\CreateEarningsLosses::route('/create'),
            'edit' => EarningsLossesResource\Pages\EditEarningsLosses::route('/{record}/edit'),
        ];
    }
}
