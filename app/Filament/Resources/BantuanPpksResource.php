<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanPpksResource\Pages;
use App\Filament\Resources\BantuanPpksResource\RelationManagers;
use App\Models\BantuanPpks;
use App\Models\KriteriaPelayanan;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanPpksResource extends Resource
{
    protected static ?string $model = BantuanPpks::class;

    protected static ?string $slug = 'bantuan-ppks';
    protected static ?string $label = 'Bantuan PPKS';
    protected static ?string $pluralLabel = 'Bantuan PPKS';
    protected static ?string $navigationLabel = 'Bantuan PPKS';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('keluarga_id')
                    ->relationship('keluarga', 'nama_lengkap')
                    ->required(),
                Forms\Components\Select::make('jenis_pelayanan_id')
                    ->relationship('jenis_pelayanan', 'nama_ppks')
                    ->required(),
                Forms\Components\Select::make('jenis_bantuan_id')
                    ->relationship('jenis_bantuan', 'nama_bantuan')
                    ->required(),
                Forms\Components\TextInput::make('anggaran_id')
                    ->required()
                    ->numeric(),
                TableRepeater::make('jenis_ppks')->schema([
                    Forms\Components\Select::make('kriteria_ppks')
                        ->options(KriteriaPelayanan::pluck('nama_kriteria', 'id'))
                ]),
                Forms\Components\TextInput::make('penghasilan_rata_rata')
                    ->numeric(),
                Forms\Components\Toggle::make('status_rumah_tinggal'),
                Forms\Components\TextInput::make('status_kondisi_rumah')
                    ->maxLength(50),
                Forms\Components\Toggle::make('status_bantuan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keluarga.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pelayanan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anggaran_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('penghasilan_rata_rata')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status_rumah_tinggal')
                    ->boolean(),
                Tables\Columns\TextColumn::make('status_kondisi_rumah')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_bantuan')
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
            'index' => Pages\ManageBantuanPpks::route('/'),
        ];
    }
}
