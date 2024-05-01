<?php

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tipe_ppks_id')
                    ->numeric(),
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
            ->columns([
                BadgeableColumn::make('nama_kriteria')
                    ->label('Kriteria Tipe PPKS')
                    ->suffixBadges([
                        Badge::make('tipePpks.nama_tipe')
                            ->label(fn(Model $record) => $record->tipePpks()->first()->nama_tipe),
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
