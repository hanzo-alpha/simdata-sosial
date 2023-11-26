<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KantorResource\Pages;
use App\Filament\Resources\KantorResource\RelationManagers;
use App\Models\Kantor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KantorResource extends Resource
{
    protected static ?string $model = Kantor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $slug = 'kantor';
    protected static ?string $label = 'Kantor';
    protected static ?string $pluralLabel = 'Kantor';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nama_kantor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pegawai_id')
                    ->numeric(),
                Forms\Components\Textarea::make('alamat')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('no_telp')
                    ->tel()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kantor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pegawai_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_telp')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageKantors::route('/'),
        ];
    }
}
