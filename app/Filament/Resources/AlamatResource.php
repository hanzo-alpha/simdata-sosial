<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlamatResource\Pages;
use App\Filament\Resources\AlamatResource\RelationManagers;
use App\Models\Alamat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AlamatResource extends Resource
{
    protected static ?string $model = Alamat::class;

    protected static ?string $slug = 'alamat';
    protected static ?string $label = 'Alamat';
    protected static ?string $pluralLabel = 'Alamat';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('keluarga_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('alamat2')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_rt')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_rw')
                    ->maxLength(255),
                Forms\Components\TextInput::make('provinsi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kabupaten')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kecamatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kelurahan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dusun')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kodepos')
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keluarga_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kodepos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
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
            'index' => Pages\ListAlamats::route('/'),
            'create' => Pages\CreateAlamat::route('/create'),
            'edit' => Pages\EditAlamat::route('/{record}/edit'),
        ];
    }
}
