<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanRastraResource\Pages;
use App\Filament\Resources\BantuanRastraResource\RelationManagers;
use App\Models\BantuanRastra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanRastraResource extends Resource
{
    protected static ?string $model = BantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $slug = 'bantuan-rastra';
    protected static ?string $label = 'Bantuan Rastra';
    protected static ?string $pluralLabel = 'Bantuan Rastra';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('keluarga_id')
                    ->relationship('keluarga', 'nama_lengkap')
                    ->required(),
                Forms\Components\TextInput::make('dtks_id')
                    ->maxLength(36),
                Forms\Components\TextInput::make('nik_penerima')
                    ->maxLength(255),
                Forms\Components\TextInput::make('attachments'),
                Forms\Components\TextInput::make('bukti_foto'),
                Forms\Components\TextInput::make('dokumen'),
                Forms\Components\TextInput::make('location'),
                Forms\Components\Toggle::make('status_rastra'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keluarga.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dtks_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_penerima')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_rastra')
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
            'index' => Pages\ManageBantuanRastras::route('/'),
        ];
    }
}
