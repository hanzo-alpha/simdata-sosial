<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\WarnaEnum;
use App\Filament\Resources\JenisBantuanResource\Pages;
use App\Models\JenisBantuan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_bantuan')
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(20),
                Forms\Components\Select::make('warna')
                    ->options(WarnaEnum::class)
                    ->preload()
                    ->lazy(),
                Forms\Components\TextInput::make('deskripsi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_bantuan')
                    ->label('Nama Bantuan')
                    ->description(fn($record) => Str::words($record->deskripsi, 13))
                    ->searchable()
                    ->weight(FontWeight::SemiBold)
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alias')
                    ->label('Alias')
                    ->badge()
                    ->sortable()
                    ->searchable()
                    ->color(fn($record) => $record->warna),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
            ])
//            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
//            ])
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
