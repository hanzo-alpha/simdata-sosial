<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\JenisBantuanResource\Pages;
use App\Models\JenisBantuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

final class JenisBantuanResource extends Resource
{
    protected static ?string $model = JenisBantuan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'jenis-bantuan';
    protected static ?string $label = 'Jenis Bantuan';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $pluralLabel = 'Jenis Bantuan';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_bantuan')
                    ->required()
                    ->maxLength(150)
                    ->dehydrateStateUsing(fn($state) => Str::of($state)->prepend('Bantuan ')->title()),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(7),
                Forms\Components\ColorPicker::make('warna'),
                Forms\Components\TextInput::make('deskripsi')
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn($state) => Str::title($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_bantuan')
                    ->label('Nama Bantuan')
                    ->description(fn($record) => $record->deskripsi)
                    ->searchable()
                    ->weight(FontWeight::SemiBold)
                    ->sortable(),
                Tables\Columns\TextColumn::make('alias')
                    ->label('Alias')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->color(fn($record) => Color::hex($record->warna)),
                Tables\Columns\ColorColumn::make('warna')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([

            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageJenisBantuan::route('/'),
        ];
    }
}
