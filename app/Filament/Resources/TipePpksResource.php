<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\TipePpksResource\Pages;
use App\Models\TipePpks;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class TipePpksResource extends Resource
{
    protected static ?string $model = TipePpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $slug = 'tipe-ppks';
    protected static ?string $label = 'Tipe PPKS';
    protected static ?string $pluralLabel = 'Tipe PPKS';
    protected static ?string $navigationLabel = 'Tipe PPKS';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_tipe')
                    ->label('Nama Tipe')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('kriteria_ppks')
                    ->label('Kriteria PPKS')
                    ->relationship()
                    ->simple(
                        Forms\Components\TextInput::make('nama_kriteria')
                            ->label('Nama Kriteria')
                            ->required()
                    )
                    ->addActionLabel('Tambah Kriteria PPKS')
                    ->reorderableWithButtons()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeableColumn::make('nama_tipe')
                    ->label('Kategori PPKS')
                    ->suffixBadges([
                        Badge::make('alias')
                            ->label(fn($record) => $record->alias)
                            ->color('success'),
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kriteria_ppks.nama_kriteria')
                    ->label('Kriteria PPKS')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList()
                    ->badge()
                    ->color('gray')
//                    ->inline()
                    ->searchable(),
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
            'index' => Pages\ManageTipePpks::route('/'),
        ];
    }
}
