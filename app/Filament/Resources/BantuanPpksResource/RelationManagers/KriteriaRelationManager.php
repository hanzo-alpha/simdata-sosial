<?php

namespace App\Filament\Resources\BantuanPpksResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class KriteriaRelationManager extends RelationManager
{
    protected static string $relationship = 'kriterias';

    public function form(Form $form): Form
    {
        return $form
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
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
