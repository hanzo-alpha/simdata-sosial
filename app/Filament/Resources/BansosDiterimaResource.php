<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BansosDiterimaResource\Pages;
use App\Models\BansosDiterima;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BansosDiterimaResource extends Resource
{
    protected static ?string $model = BansosDiterima::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'bansos-yang-diterima';
    protected static ?string $label = 'Bansos Yang Diterima';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $pluralLabel = 'Bansos Yang Diterima';
    protected static ?string $modelLabel = 'Bansos Yang Diterima';
    protected static ?string $recordTitleAttribute = 'nama_bansos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_bansos')
                    ->label('Nama BANSOS')
                    ->required()
                    ->autofocus(),
                TextInput::make('deskripsi')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama_bansos')
                    ->label('Nama BANSOS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi'),
            ])
            ->filters([

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
            'index' => Pages\ManageBansosDiterimas::route('/'),
        ];
    }
}
