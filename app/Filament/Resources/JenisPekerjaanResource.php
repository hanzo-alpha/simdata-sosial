<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\JenisPekerjaanResource\Pages;
use App\Models\JenisPekerjaan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class JenisPekerjaanResource extends Resource
{
    protected static ?string $model = JenisPekerjaan::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $slug = 'jenis-pekerjaan';
    protected static ?string $label = 'Jenis Pekerjaan';
    protected static ?string $pluralLabel = 'Jenis Pekerjaan';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pekerjaan')
                    ->label('Nama Pekerjaan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada jenis pekerjaan')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_pekerjaan'),
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
            'index' => Pages\ManageJenisPekerjaan::route('/'),
        ];
    }
}
