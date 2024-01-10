<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;
use App\Filament\Resources\PenyaluranBantuanRastraResource\RelationManagers;
use App\Models\PenyaluranBantuanRastra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenyaluranBantuanRastraResource extends Resource
{
    protected static ?string $model = PenyaluranBantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $slug = 'penyaluran-bantuan-rastra';
    protected static ?string $label = 'Penyaluran Rastra';
    protected static ?string $pluralLabel = 'Penyaluran Rastra';
    protected static ?string $navigationGroup = 'Program';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bantuan_rastra_id')
                    ->numeric(),
                Forms\Components\DateTimePicker::make('tgl_penyerahan'),
                Forms\Components\TextInput::make('foto_penyerahan')
                    ->required(),
                Forms\Components\TextInput::make('foto_ktp_kk')
                    ->required(),
                Forms\Components\TextInput::make('lat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lng')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bantuan_rastra_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_penyerahan')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lng')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPenyaluranBantuanRastras::route('/'),
            'create' => Pages\CreatePenyaluranBantuanRastra::route('/create'),
            'edit' => Pages\EditPenyaluranBantuanRastra::route('/{record}/edit'),
        ];
    }
}
