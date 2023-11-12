<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanBpntResource\Pages;
use App\Filament\Resources\BantuanBpntResource\RelationManagers;
use App\Models\BantuanBpnt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanBpntResource extends Resource
{
    protected static ?string $model = BantuanBpnt::class;

    protected static ?string $slug = 'bantuan-bpnt';
    protected static ?string $label = 'Bantuan BPNT';
    protected static ?string $pluralLabel = 'Bantuan BPNT';
    protected static ?string $navigationLabel = 'Bantuan BPNT';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('keluarga_id')
                    ->relationship('keluarga', 'nama_lengkap')
                    ->required(),
                Forms\Components\TextInput::make('kode_wilayah')
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahap')
                    ->maxLength(255),
                Forms\Components\Select::make('jenis_bantuan_id')
                    ->relationship('jenis_bantuan', 'id'),
                Forms\Components\TextInput::make('nominal')
                    ->numeric(),
                Forms\Components\TextInput::make('dtks_id')
                    ->maxLength(36),
                Forms\Components\TextInput::make('bank')
                    ->maxLength(255),
                Forms\Components\TextInput::make('dir')
                    ->maxLength(255),
                Forms\Components\TextInput::make('gelombang')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status_bpnt'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keluarga_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dtks_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gelombang')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_bpnt')
                    ->boolean(),
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
            'index' => Pages\ManageBantuanBpnts::route('/'),
        ];
    }
}
