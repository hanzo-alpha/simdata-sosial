<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanBpjsResource\Pages;
use App\Filament\Resources\BantuanBpjsResource\RelationManagers;
use App\Models\BantuanBpjs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanBpjsResource extends Resource
{
    protected static ?string $model = BantuanBpjs::class;

    protected static ?string $slug = 'bantuan-bpjs';
    protected static ?string $label = 'Bantuan BPJS';
    protected static ?string $pluralLabel = 'Bantuan BPJS';
    protected static ?string $navigationLabel = 'Bantuan BPJS';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('keluarga_id')
                    ->relationship('keluarga', 'nama_lengkap')
                    ->required(),
                Forms\Components\TextInput::make('dkts_id')
                    ->maxLength(36),
                Forms\Components\TextInput::make('attachments'),
                Forms\Components\TextInput::make('bukti_foto'),
                Forms\Components\TextInput::make('dokumen'),
                Forms\Components\Toggle::make('status_bpjs'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keluarga.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dkts_id')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_bpjs')
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
            'index' => Pages\ManageBantuanBpjs::route('/'),
        ];
    }
}
