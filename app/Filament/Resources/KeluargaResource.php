<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusKawinEnum;
use App\Filament\Resources\KeluargaResource\Pages;
use App\Filament\Resources\KeluargaResource\RelationManagers;
use App\Models\Keluarga;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Wallo\FilamentSelectify\Components\ToggleButton;

class KeluargaResource extends Resource
{
    protected static ?string $model = Keluarga::class;

    protected static ?string $slug = 'keluarga';
    protected static ?string $label = 'Keluarga';
    protected static ?string $pluralLabel = 'Keluarga';
    protected static ?string $navigationGroup = 'Master';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Data Pribadi')
                        ->schema([
                            Forms\Components\TextInput::make('nokk')
                                ->label('No. Kartu Keluarga')
                                ->autofocus()
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nik')
                                ->label('Nomor Induk Kependudukan (NIK)')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('notelp')
                                ->label('No. Telp/HP')
                                ->tel()
                                ->required()
                                ->maxLength(18),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\DatePicker::make('tgl_lahir')
                                ->label('Tanggal Lahir')
                                ->required(),

                        ])->columns(2),
                    Forms\Components\Wizard\Step::make('Data Lainnya')
                        ->schema([
                            Forms\Components\Select::make('alamat_id')
                                ->relationship('alamat', 'id')
                                ->required(),
                            Forms\Components\Select::make('jenis_bantuan_id')
                                ->required()
                                ->relationship('jenis_bantuan', 'nama_bantuan'),
                            Forms\Components\Select::make('pendidikan_terakhir_id')
                                ->required()
                                ->relationship('pendidikan_terakhir', 'nama_pendidikan'),
                            Forms\Components\Select::make('hubungan_keluarga_id')
                                ->required()
                                ->relationship('hubungan_keluarga', 'nama_hubungan'),
                            Forms\Components\Select::make('jenis_pekerjaan_id')
                                ->required()
                                ->relationship('jenis_pekerjaan', 'nama_pekerjaan'),

                            Forms\Components\TextInput::make('nama_ibu_kandung')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('status_kawin')
                                ->options(StatusKawinEnum::class),
                            Forms\Components\Select::make('jenis_kelamin')
                                ->options(JenisKelaminEnum::class),
                            ToggleButton::make('status_keluarga')
                                ->offColor('danger')
                                ->onColor('primary')
                                ->offLabel('Non Aktif')
                                ->onLabel('Aktif')
                                ->default(true),
//                            ButtonGroup::make('status_keluarga')
//                                ->options(StatusAktif::class)
//                                ->onColor('primary')
//                                ->offColor('gray')
//                                ->gridDirection('column')
//                                ->default(StatusAktif::AKTIF)
//                                ->icons([
//                                    1 => 'heroicon-m-user',
//                                    0 => 'heroicon-m-building-office',
//                                ])
//                                ->iconPosition(\Filament\Support\Enums\IconPosition::After)
//                                ->iconSize(IconSize::Medium),
                        ])->columns(2)
                ])->skippable(),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alamat.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_bantuan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pendidikan_terakhir_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hubungan_keluarga_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pekerjaan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('notelp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_ibu_kandung')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_kawin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('jenis_kelamin')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status_keluarga')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AnggotaRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKeluarga::route('/'),
            'create' => Pages\CreateKeluarga::route('/create'),
            'edit' => Pages\EditKeluarga::route('/{record}/edit'),
        ];
    }
}
