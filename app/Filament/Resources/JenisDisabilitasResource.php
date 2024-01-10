<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisDisabilitasResource\Pages;
use App\Filament\Resources\JenisDisabilitasResource\RelationManagers;
use App\Models\JenisDisabilitas;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
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

    protected static bool $shouldRegisterNavigation = false;

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
                    ->label('Sub Jenis Disabilitas')
                    ->relationship()
                    ->simple(
                        Forms\Components\TextInput::make('nama_sub_jenis')
                            ->label('Nama Sub Jenis')
                            ->required()
                    )
                    ->addActionLabel('Tambah Sub Jenis Disabilitas')
                    ->reorderableWithButtons()
                    ->columnSpan('full'),
            ])->inlineLabel()->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                BadgeableColumn::make('nama_penyandang')
                    ->label('Jenis Disabilitas')
                    ->suffixBadges([
                        Badge::make('alias')
                            ->label(fn($record) => $record->alias)
                            ->color('primary')
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sub_jenis_disabilitas.nama_sub_jenis')
                    ->label('Kriteria Disabilitas')
                    ->wrap()
                    ->inline()
                    ->badge()
                    ->color('gray')
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
