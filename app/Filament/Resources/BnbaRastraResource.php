<?php

namespace App\Filament\Resources;

use App\Enums\StatusDtksEnum;
use App\Filament\Resources\BnbaRastraResource\Pages;
use App\Models\BnbaRastra;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BnbaRastraResource extends Resource
{
    protected static ?string $model = BnbaRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'bnba-rastra';
    protected static ?string $label = 'BNBA Rastra';
    protected static ?string $pluralLabel = 'BNBA Rastra';
    protected static ?string $navigationParentItem = 'Program BPNT';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('dtks_id')
                    ->preload()
                    ->options(StatusDtksEnum::class)
                    ->optionsLimit(100)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


            ])
            ->filters([

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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBnbaRastras::route('/'),
            'create' => Pages\CreateBnbaRastra::route('/create'),
            'edit' => Pages\EditBnbaRastra::route('/{record}/edit'),
        ];
    }
}