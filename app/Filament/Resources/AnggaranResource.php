<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggaranResource\Pages;
use App\Filament\Resources\AnggaranResource\RelationManagers;
use App\Models\Anggaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AnggaranResource extends Resource
{
    protected static ?string $model = Anggaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $slug = 'anggaran';
    protected static ?string $label = 'Anggaran';
    protected static ?string $pluralLabel = 'Anggaran';
    protected static ?string $navigationGroup = 'Master';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_anggaran')
                    ->required()
                    ->autofocus()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_anggaran')
                    ->numeric(),
                Forms\Components\TextInput::make('tahun_anggaran')
                    ->default(now()->year),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_anggaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_anggaran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun_anggaran')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ManageAnggarans::route('/'),
        ];
    }
}
