<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusKawinEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\KeluargaResource\Pages;
use App\Filament\Resources\KeluargaResource\RelationManagers;
use App\Forms\Components\AlamatForm;
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
                    Forms\Components\Wizard\Step::make('Data Keluarga')
                        ->schema(static::getFormSchema('keluarga'))->columns(2),
                    Forms\Components\Wizard\Step::make('Alamat Keluarga')
                        ->schema(static::getFormSchema('alamat'))->columns(2),
                    Forms\Components\Wizard\Step::make('Data Lainnya')
                        ->schema(static::getFormSchema('lainnya'))->columns(2),
                    Forms\Components\Wizard\Step::make('Unggah Data')
                        ->schema(static::getFormSchema('upload'))->columns(2)
                ])->skippable(),

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('alamat.alamat')
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
            RelationManagers\AddressesRelationManager::class,
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

    public static function getNavigationBadge(): ?string
    {
        return static::$model::where('status_keluarga', StatusAktif::AKTIF)->count();
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['anggota', 'alamat', 'jenis_bantuan']);
    }

    public static function getFormSchema(string $section = null): array
    {
        if ($section === 'keluarga') {
            return [
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
            ];
        }

        if ($section === 'alamat') {
            return [
//                AddressForm::make('address')
//                    ->relationship('prov')
//                    ->columnSpan('full'),
                AlamatForm::make('alamat')
                    ->columnSpanFull(),
//                Forms\Components\Select::make('alamat')
//                    ->preload()
//                    ->optionsLimit(10)
//                    ->relationship('alamat.alamat')
            ];
        }

        if ($section === 'upload') {
            return [
                Forms\Components\Grid::make()->schema([
                    Forms\Components\FileUpload::make('unggah_foto')
                        ->label('Unggah Foto')
                        ->multiple()
                        ->required()
                        ->helperText('maks. 2MB')
                        ->image(),

                    Forms\Components\FileUpload::make('unggah_dokumen')
                        ->label('Unggah File Pendukung Lainnya')
                        ->multiple()
                        ->helperText('maks. 5MB')
                        ->required(),
                ])

            ];
        }

        return [
            Forms\Components\Select::make('jenis_bantuan_id')
                ->required()
                ->searchable()
                ->relationship('jenis_bantuan', 'nama_bantuan')
                ->preload()
                ->optionsLimit(20),
            Forms\Components\Select::make('pendidikan_terakhir_id')
                ->required()
                ->searchable()
                ->relationship('pendidikan_terakhir', 'nama_pendidikan')
                ->preload()
                ->optionsLimit(20),
            Forms\Components\Select::make('hubungan_keluarga_id')
                ->required()
                ->searchable()
                ->relationship('hubungan_keluarga', 'nama_hubungan')
                ->preload()
                ->optionsLimit(20),
            Forms\Components\Select::make('jenis_pekerjaan_id')
                ->required()
                ->searchable()
                ->relationship('jenis_pekerjaan', 'nama_pekerjaan')
                ->preload()
                ->optionsLimit(20),

            Forms\Components\TextInput::make('nama_ibu_kandung')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('status_kawin')
                ->searchable()
                ->options(StatusKawinEnum::class),
            Forms\Components\Select::make('jenis_kelamin')
                ->options(JenisKelaminEnum::class),
            Forms\Components\Select::make('status_verifikasi')
                ->options(StatusVerifikasiEnum::class),
            ToggleButton::make('status_keluarga')
                ->offColor('danger')
                ->onColor('primary')
                ->offLabel('Non Aktif')
                ->onLabel('Aktif')
                ->default(true),
        ];
    }
}
