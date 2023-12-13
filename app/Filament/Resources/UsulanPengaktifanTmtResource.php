<?php

namespace App\Filament\Resources;

use App\Enums\JenisKelaminEnum;
use App\Enums\StatusAktif;
use App\Enums\StatusBpjsEnum;
use App\Enums\StatusKawinBpjsEnum;
use App\Enums\StatusUsulanEnum;
use App\Enums\StatusVerifikasiEnum;
use App\Filament\Resources\UsulanPengaktifanTmtResource\Pages;
use App\Filament\Resources\UsulanPengaktifanTmtResource\RelationManagers;
use App\Forms\Components\AlamatForm;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UsulanPengaktifanTmt;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Wallo\FilamentSelectify\Components\ToggleButton;

class UsulanPengaktifanTmtResource extends Resource
{
    protected static ?string $model = UsulanPengaktifanTmt::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'usulan-pengaktifan-tmt';
    protected static ?string $label = 'Usulan Pengaktifan TMT';
    protected static ?string $pluralLabel = 'Usulan Pengaktifan TMT';
    protected static ?string $navigationLabel = 'Bantuan BPJS';
    protected static ?string $navigationGroup = 'Bantuan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Data Keluarga')
                        ->schema([
                            Forms\Components\TextInput::make('nokk_tmt')
                                ->label('No. Kartu Keluarga (KK)')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nik_tmt')
                                ->label('N I K')
                                ->required()
                                ->maxLength(20),
                            Forms\Components\TextInput::make('nama_lengkap')
                                ->label('Nama Lengkap')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->maxLength(100),
                            Forms\Components\DatePicker::make('tgl_lahir')
                                ->label('Tgl. Lahir')
                                ->displayFormat('d/M/Y'),
                            Forms\Components\Select::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->options(JenisKelaminEnum::class)
                                ->default(JenisKelaminEnum::LAKI),
                        ])->columns(2),
                    Forms\Components\Section::make('Alamat')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    TextInput::make('alamat')
                                        ->required()
                                        ->columnSpanFull(),
                                    Select::make('kecamatan')
                                        ->required()
                                        ->searchable()
                                        ->reactive()
                                        ->options(function () {
                                            $kab = Kecamatan::query()->where('kabupaten_code',
                                                config('custom.default.kodekab'));
                                            if (!$kab) {
                                                return Kecamatan::where('kabupaten_code',
                                                    config('custom.default.kodekab'))
                                                    ->pluck('name', 'code');
                                            }

                                            return $kab->pluck('name', 'code');
                                        })
                                        ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                                    Select::make('kelurahan')
                                        ->required()
                                        ->options(function (callable $get) {
                                            return Kelurahan::query()->where('kecamatan_code',
                                                $get('kecamatan'))?->pluck('name',
                                                'code');
                                        })
                                        ->reactive()
                                        ->searchable(),
                                ]),

                            Grid::make(4)
                                ->schema([
                                    TextInput::make('dusun')
                                        ->label('Dusun')
                                        ->nullable(),
                                    TextInput::make('nort')
                                        ->label('RT')
                                        ->nullable(),
                                    TextInput::make('norw')
                                        ->label('RW')
                                        ->nullable(),
                                    TextInput::make('kodepos')
                                        ->label('Kodepos')
                                        ->default('90861')
                                        ->required(),
                                ]),
                        ]),
                ])->columnSpan(2),
                Forms\Components\Group::make([
                    Forms\Components\Section::make('Status')
                        ->schema([
                            Select::make('status_nikah')
                                ->options(StatusKawinBpjsEnum::class)
                                ->default(StatusKawinBpjsEnum::BELUM_KAWIN)
                                ->preload(),
                            Forms\Components\Select::make('status_bpjs')
                                ->label('Status BPJS')
                                ->enum(StatusBpjsEnum::class)
                                ->options(StatusBpjsEnum::class)
                                ->default(StatusBpjsEnum::PENGAKTIFAN)
                                ->live()
                                ->preload(),

                            Forms\Components\Select::make('status_usulan')
                                ->label('Status TL')
                                ->enum(StatusUsulanEnum::class)
                                ->options(StatusUsulanEnum::class)
                                ->default(StatusUsulanEnum::ONPROGRESS)
                                ->live()
                                ->preload(),

                            ToggleButton::make('status_aktif')
                                ->label('Status Aktif')
                                ->offColor(StatusAktif::NONAKTIF->getColor())
                                ->onColor(StatusAktif::AKTIF->getColor())
                                ->offLabel(StatusAktif::NONAKTIF->getLabel())
                                ->onLabel(StatusAktif::AKTIF->getLabel())
                                ->default(0),

                            Forms\Components\Textarea::make('keterangan')
                                ->autosize()
                        ]),
                ])->columns(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->sortable()
                    ->description(fn($record) => 'NO.KK : ' . $record->nokk_tmt)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_tmt')
                    ->label('NIK')
                    ->sortable()
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->description(fn($record) => $record->tgl_lahir->format('d/M/Y'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->label('Tgl. Lahir')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('status_nikah')
                    ->label('Status Nikah')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge(),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(function ($record) {
                        $rt = $record['nort'];
                        $rw = $record['norw'];
                        $dusun = $record['dusun'];
                        $kodepos = $record['kodepos'];
                        $kec = $record->kec?->name;
                        $kel = $record->kel?->name;
                        return $dusun . ' ' . 'RT.' . $rt . '/' . 'RW.' . $rw . ' ' . $kec . ', ' . $kel . ', ' . $kodepos;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('kec.kecamatan')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.kelurahan')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('bulan')
                    ->label('Periode')
                    ->formatStateUsing(fn($record) => $record->bulan . ' ' . $record->tahun),
                Tables\Columns\TextColumn::make('dusun')
                    ->label('Dusun')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_aktif')
                    ->label('Status Aktif')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('status_bpjs')
                    ->label('Status BPJS')
                    ->sortable()
                    ->toggleable()
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status_aktif')
                    ->label('Status Aktif')
                    ->options(StatusAktif::class)
                    ->preload(),
                SelectFilter::make('status_bpjs')
                    ->label('Status BPJS')
                    ->options(StatusBpjsEnum::class),
                SelectFilter::make('status_nikah')
                    ->label('Status Nikah')
                    ->options(StatusKawinBpjsEnum::class),
                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options(JenisKelaminEnum::class),
                DateRangeFilter::make('created_at')
                    ->label('Rentang Tanggal')
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->persistFiltersInSession()
            ->deselectAllRecordsWhenFiltered()
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsulanPengaktifanTmt::route('/'),
            'create' => Pages\CreateUsulanPengaktifanTmt::route('/create'),
            'view' => Pages\ViewUsulanPengaktifanTmt::route('/{record}'),
            'edit' => Pages\EditUsulanPengaktifanTmt::route('/{record}/edit'),
        ];
    }
}
