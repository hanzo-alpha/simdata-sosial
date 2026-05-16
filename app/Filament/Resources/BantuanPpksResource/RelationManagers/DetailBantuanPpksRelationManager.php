<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\RelationManagers;

use App\Enums\JenisAnggaranEnum;
use Filament\Actions;
use Filament\Actions\DetachAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class DetailBantuanPpksRelationManager extends RelationManager
{
    protected static string $relationship = 'detailBantuanPpks';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('nama_bantuan')
                    ->label('Nama Bantuan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_bantuan')
                    ->label('Jumlah Bantuan')
                    ->default(1)
                    ->numeric(),
                Forms\Components\Select::make('jenis_anggaran')
                    ->label('Jenis Anggaran')
                    ->options(JenisAnggaranEnum::class)
                    ->required()
                    ->default(JenisAnggaranEnum::APBD)
                    ->preload()
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_bantuan')
            ->columns([
                Tables\Columns\TextColumn::make('nama_bantuan'),
                Tables\Columns\TextColumn::make('jumlah_bantuan'),
                Tables\Columns\TextColumn::make('jenis_anggaran')->searchable()->label('Jenis Anggaran'),
                Tables\Columns\TextColumn::make('tahun_anggaran')->searchable()->label('Tahun Anggaran'),
            ])
            ->filters([

            ])
            ->headerActions([
                Actions\AttachAction::make(),
                Actions\CreateAction::make(),
            ])
            ->actions([
                DetachAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DetachBulkAction::make(),
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
