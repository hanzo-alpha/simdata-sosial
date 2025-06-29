<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\JenisAnggaranEnum;
use App\Enums\StatusDtksEnum;
use App\Filament\Resources\DetailBantuanPpksResource\Pages;
use App\Models\DetailBantuanPpks;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DetailBantuanPpksResource extends Resource
{
    protected static ?string $model = DetailBantuanPpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'detail-bantuan-ppks';

    protected static ?string $label = 'Detail Bantuan PPKS';

    protected static ?string $pluralLabel = 'Detail Bantuan PPKS';
    protected static ?string $navigationParentItem = 'Program PPKS';
    protected static ?string $navigationGroup = 'Program Sosial';

    protected static ?string $recordTitleAttribute = 'nama_bantuan';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('bantuan_ppks_id')
                        ->relationship(
                            name: 'bantuanPpks',
                            titleAttribute: 'nama_lengkap',
                            modifyQueryUsing: fn($query) => $query->where('status_dtks', StatusDtksEnum::DTKS),
                        )
                        ->preload()
                        ->native(false)
                        ->required(),
                    Forms\Components\TextInput::make('nama_bantuan')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('jumlah_bantuan')
                        ->numeric(),
                    Forms\Components\Select::make('jenis_anggaran')
                        ->options(JenisAnggaranEnum::class)
                        ->native(false)
                        ->required()
                        ->preload(),
                    Forms\Components\TextInput::make('tahun_anggaran')
                        ->numeric()
                        ->default(2025),
                ])->inlineLabel(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bantuanPpks.nama_lengkap')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_bantuan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_bantuan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_anggaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_anggaran')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageDetailBantuanPpks::route('/'),
        ];
    }
}
