<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KriteriaPelayananResource\Pages;
use App\Filament\Resources\KriteriaPelayananResource\RelationManagers;
use App\Models\SubJenisDisabilitas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KriteriaPelayananResource extends Resource
{
    protected static ?string $model = SubJenisDisabilitas::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $slug = 'kriteria-pelayanan';
    protected static ?string $label = 'Kriteria Pelayanan';
    protected static ?string $navigationGroup = 'Master';
    protected static ?string $pluralLabel = 'Kriteria Pelayanan';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis_pelayanan_id')
                    ->required()
                    ->relationship('jenisPelayanan', 'nama_ppks'),
                Forms\Components\TextInput::make('nama_kriteria')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('jenisPelayanan.nama_ppks')
            ->columns([
                Tables\Columns\TextColumn::make('nama_kriteria')
                    ->searchable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
            'index' => Pages\ManageKriteriaPelayanans::route('/'),
        ];
    }
}
