<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BansosDiterimaResource\Pages;
use App\Models\BansosDiterima;
use BackedEnum;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class BansosDiterimaResource extends Resource
{
    protected static ?string $model = BansosDiterima::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'bansos-yang-diterima';
    protected static ?string $label = 'Bansos Yang Diterima';
    protected static string|UnitEnum|null $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $pluralLabel = 'Bansos Yang Diterima';
    protected static ?string $modelLabel = 'Bansos Yang Diterima';
    protected static ?string $recordTitleAttribute = 'nama_bansos';

    public static function form(Schema $schema): Schema
    {
        return $schema
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
            ->defaultSort('nama_bansos')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada Bansos diterima')
            ->emptyStateActions([
                Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_bansos')
                    ->label('Nama BANSOS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deskripsi'),
            ])
            ->filters([

            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->after(fn(\Illuminate\Support\Collection $records) => activity()
                            ->log('Hapus masal ' . $records->count() . ' data bansos diterima')),
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
