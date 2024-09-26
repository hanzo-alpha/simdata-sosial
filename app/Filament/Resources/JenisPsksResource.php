<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPsksResource\Pages;
use App\Models\JenisPsks;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JenisPsksResource extends Resource
{
    protected static ?string $model = JenisPsks::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'jenis-psks';
    protected static ?string $label = 'Jenis PSKS';
    protected static ?string $pluralLabel = 'Jenis PSKS';
    protected static ?string $navigationLabel = 'Jenis PSKS';
    protected static ?string $navigationParentItem = 'Tipe PPKS';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $recordTitleAttribute = 'nama_psks';

    public static function form(Form $form): Form
    {
        return $form
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
                Tables\Actions\CreateAction::make()
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
            'index' => Pages\ManageJenisPsks::route('/'),
        ];
    }
}
