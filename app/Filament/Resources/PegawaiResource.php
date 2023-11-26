<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $slug = 'pegawai';
    protected static ?string $label = 'Pegawai';
    protected static ?string $pluralLabel = 'Pegawai';
    protected static ?string $navigationGroup = 'Pengaturan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('kantor_id')
                    ->relationship('kantor', 'id')
                    ->required(),
                Forms\Components\TextInput::make('nama_pegawai')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik_pegawai')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_telp')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('role_id')
                    ->numeric()
                    ->default(1),
                Forms\Components\Toggle::make('status_pegawai'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kantor.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_pegawai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_pegawai')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_telp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status_pegawai')
                    ->boolean(),
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
            'index' => Pages\ManagePegawais::route('/'),
        ];
    }
}
