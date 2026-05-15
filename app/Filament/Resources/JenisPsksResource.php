<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPsksResource\Pages;
use App\Models\JenisPsks;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class JenisPsksResource extends Resource
{
    protected static ?string $model = JenisPsks::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'jenis-psks';
    protected static ?string $label = 'Jenis PSKS';
    protected static ?string $pluralLabel = 'Jenis PSKS';
    protected static ?string $navigationLabel = 'Jenis PSKS';
    protected static ?string $navigationParentItem = 'Tipe PPKS';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $recordTitleAttribute = 'nama_psks';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('nama_psks')
                    ->required(),
                TextInput::make('alias')->nullable(),
                TextInput::make('deskripsi')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada jenis PSKS')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama_psks')
                    ->label('Nama PSKS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('alias')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->words(5)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

            ])
            ->actions([
                Actions\ActionGroup::make([
                    Actions\ViewAction::make(),
                    Actions\EditAction::make(),
                    Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageJenisPsks::route('/'),
        ];
    }
}
