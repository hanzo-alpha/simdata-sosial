<?php

declare(strict_types=1);

namespace App\Filament\Resources\BantuanPpksResource\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class KriteriaRelationManager extends RelationManager
{
    protected static string $relationship = 'kriterias';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('tipe_ppks_id')
                    ->relationship('tipe_ppks', 'nama_tipe')
                    ->preload()
                    ->minItems(10),
                Forms\Components\TextInput::make('nama_kriteria')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_kriteria')
            ->columns([
                Tables\Columns\TextColumn::make('tipe_ppks.nama_tipe'),
                Tables\Columns\TextColumn::make('nama_kriteria'),
            ])
            ->filters([

            ])
            ->headerActions([
                Actions\CreateAction::make(),
                Actions\AssociateAction::make(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DissociateAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DissociateBulkAction::make(),
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
