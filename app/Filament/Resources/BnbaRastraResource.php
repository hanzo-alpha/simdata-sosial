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
    protected static ?string $navigationParentItem = 'Program Rastra';
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
                Tables\Columns\TextColumn::make('no_kk')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('N I K')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('NAMA KPM')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_dtks')
                    ->label('Status DTKS')
                    ->sortable()
                    ->searchable()
                    ->badge(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
//                    Tables\Actions\ExportBulkAction::make()
//                        ->label('Ekspor CSV yang dipilih')
//                        ->exporter(BnbaRastraExporter::class)
//                        ->color('info')
//                        ->maxRows(10000)
//                        ->chunkSize(200)
//                        ->icon('heroicon-o-arrow-down-tray'),
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
