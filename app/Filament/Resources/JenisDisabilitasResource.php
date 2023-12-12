<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisDisabilitasResource\Pages;
use App\Filament\Resources\JenisDisabilitasResource\RelationManagers;
use App\Models\JenisDisabilitas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JenisDisabilitasResource extends Resource
{
    protected static ?string $model = JenisDisabilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'jenis-disabilitas';
    protected static ?string $label = 'Jenis  Disabilitas';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $pluralLabel = 'Jenis  Disabilitas';
    protected static ?string $navigationLabel = 'Jenis Disabilitas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_penyandang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(255),
                Forms\Components\Repeater::make('sub_jenis_disabilitas')
                    ->relationship()
                    ->simple(Forms\Components\TextInput::make('nama_sub_jenis')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_penyandang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alias')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_jenis_disabilitas.nama_sub_jenis')
                    ->listWithLineBreaks()
                    ->badge()
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
            'index' => Pages\ManageJenisDisabilitas::route('/'),
        ];
    }
}
