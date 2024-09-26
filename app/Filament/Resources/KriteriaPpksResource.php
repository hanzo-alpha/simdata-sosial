<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\KriteriaPpksResource\Pages;
use App\Models\KriteriaPpks;
use Awcodes\FilamentBadgeableColumn\Components\Badge;
use Awcodes\FilamentBadgeableColumn\Components\BadgeableColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class KriteriaPpksResource extends Resource
{
    protected static ?string $model = KriteriaPpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $slug = 'kriteria-ppks';
    protected static ?string $label = 'Kriteria PPKS';
    protected static ?string $pluralLabel = 'Kriteria PPKS';
    protected static ?string $navigationLabel = 'Kriteria PPKS';
    protected static ?string $navigationParentItem = 'Tipe PPKS';
    protected static ?string $navigationGroup = 'Dashboard Bantuan';
    protected static ?string $recordTitleAttribute = 'nama_kriteria';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tipe_ppks_id')
                    ->relationship('tipe_ppks', 'nama_tipe')
                    ->searchable()
                    ->label('Tipe PPKS')
                    ->required()
                    ->default(1)
                    ->columnSpanFull()
                    ->native(false)
                    ->preload(),
                Forms\Components\TextInput::make('nama_kriteria')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('alias')
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada kriteria PPKS')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                //                Tables\Columns\TextColumn::make('nama_kriteria'),
                BadgeableColumn::make('nama_kriteria')
                    ->label('Kriteria Tipe PPKS')
                    ->searchable()
                    ->suffixBadges([
                        Badge::make('tipe_ppks.nama_tipe')
                            ->label(fn(Model $record) => $record->tipe_ppks()->first()->nama_tipe),
                    ]),
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
            'index' => Pages\ManageKriteriaPpks::route('/'),
        ];
    }
}
