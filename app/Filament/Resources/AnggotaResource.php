<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaResource\Pages;
use App\Filament\Resources\AnggotaResource\RelationManagers;
use App\Models\Anggota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $slug = 'anggota';
    protected static ?string $label = 'Anggota';
    protected static ?string $pluralLabel = 'Anggota';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis_bantuan_id')
                    ->relationship('jenis_bantuan', 'id')
                    ->required(),
                Forms\Components\Select::make('pendidikan_terakhir_id')
                    ->relationship('pendidikan_terakhir', 'id')
                    ->required(),
                Forms\Components\Select::make('hubungan_keluarga_id')
                    ->relationship('hubungan_keluarga', 'id')
                    ->required(),
                Forms\Components\Select::make('jenis_pekerjaan_id')
                    ->relationship('jenis_pekerjaan', 'id')
                    ->required(),
                Forms\Components\TextInput::make('nokk')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_anggota')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alamat_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tgl_lahir')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('notelp')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('status_kawin'),
                Forms\Components\Toggle::make('jenis_kelamin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis_bantuan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hubungan_keluarga.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pekerjaan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('notelp')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_kawin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('jenis_kelamin')
                    ->boolean(),
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
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }
}
