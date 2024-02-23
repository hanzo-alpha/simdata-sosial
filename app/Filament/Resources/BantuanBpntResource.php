<?php

namespace App\Filament\Resources;

use App\Exports\ExportBantuanBpnt;
use App\Filament\Resources\BantuanBpntResource\Pages;
use App\Models\BantuanBpnt;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BantuanBpntResource extends Resource
{
    protected static ?string $model = BantuanBpnt::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $slug = 'program-bpnt';
    protected static ?string $label = 'Program BPNT';
    protected static ?string $pluralLabel = 'Program BPNT';
    protected static ?string $navigationLabel = 'Program BPNT';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Pribadi')->schema([
                    TextInput::make('dtks_id')
                        ->required()
                        ->default(Str::upper(Str::orderedUuid()->toString()))
                        ->maxLength(36),
                    TextInput::make('nokk')
                        ->required(),
                    TextInput::make('nik_ktp')
                        ->required(),
                    TextInput::make('nama_penerima')
                        ->required(),
                ])
                    ->columns(2),
                Section::make('Data Bantuan')->schema([
                    TextInput::make('tahap')
                        ->default(1),
                    TextInput::make('bansos')
                        ->default('PKH'),
                    TextInput::make('bank')
                        ->default('MANDIRI'),
                    TextInput::make('nominal')
                        ->default(0)
                        ->numeric(),
                    TextInput::make('dir')
                        ->default('DIR REHSOS'),
                    TextInput::make('gelombang')
                        ->default('GEL 1'),
                ])
//                    ->visibleOn(['edit', 'view'])
                    ->columns(2),
                Section::make('Data Alamat')->schema([
                    TextInput::make('alamat')
                        ->required()
                        ->columnSpanFull(),
                    Grid::make()->schema([
                        Select::make('provinsi')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(Provinsi::pluck('name', 'code'))
                            ->default(setting('app.kodeprov', config('custom.default.kodeprov')))
                            ->afterStateUpdated(fn(callable $set) => $set('kabupaten', null)),

                        Select::make('kabupaten')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                if (!$kab) {
                                    return Kabupaten::where('code', setting(
                                        'app.kodekab',
                                        config('custom.default.kodekab')
                                    ))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->reactive()
                            ->default(config('custom.default.kodekab'))
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(fn(callable $set) => $set('kecamatan', null)),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(2),
                    Grid::make()->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(function (callable $get) {
                                $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                if (!$kab) {
                                    return Kecamatan::where('kabupaten_code', setting(
                                        'app.kodekab',
                                        config('custom.default.kodekab')
                                    ))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kel = Kelurahan::query()->where('kecamatan_code', $get('kecamatan'));
                                if (!$kel) {
                                    return Kelurahan::where('kecamatan_code', '731211')
                                        ->pluck('name', 'code');
                                }

                                return $kel->pluck('name', 'code');
                            })
                            ->reactive()
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(function (callable $set, $state): void {
                                $village = Kelurahan::where('code', $state)->first();
                                if ($village) {
                                    $set('latitude', $village['latitude']);
                                    $set('longitude', $village['longitude']);
                                    $set('location', [
                                        'lat' => (float) $village['latitude'],
                                        'lng' => (float) $village['longitude'],
                                    ]);
                                }

                            }),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(2),
                    Grid::make()->schema([
                        TextInput::make('dusun'),
                        TextInput::make('no_rt'),
                        TextInput::make('no_rw'),
                    ])
//                        ->visibleOn(['edit', 'view'])
                        ->columns(3),
                ])
//                    ->visibleOn(['edit', 'view'])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->columns([
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->label('Nama Penerima')
                    ->sortable()
                    ->description(fn($record) => $record->dtks_id)
                    ->searchable(),
                Tables\Columns\TextColumn::make('nokk')
                    ->label('No. KK')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik_ktp')
                    ->label('N I K')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kode_wilayah')
                    ->label('Kode Wilayah')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahap')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bansos')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_bantuan.nama_bantuan')
                    ->label('Bantuan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nominal')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->sortable()
                    ->toggleable()
                    ->description(fn($record) => 'Kec. '.$record->kec()->get()->first()->name.' | Kel. '.
                        $record->kel()->get()->first()->name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->label('No. RT')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rw')
                    ->label('No. RW')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dir')
                    ->label('Dir/Gel')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->description(fn($record): string => $record->gelombang)
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_bpnt')
                    ->label('Status')
                    ->alignCenter()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //                Tables\Filters\SelectFilter::make('kecamatan')
                //                    ->relationship('kec', 'name')
                //                    ->searchable()
                //                    ->optionsLimit(10),
                //                Tables\Filters\SelectFilter::make('kelurahan')
                //                    ->relationship('kel', 'name')
                //                    ->searchable()
                //                    ->optionsLimit(10),
                SelectFilter::make('tahun')
                    ->label('Tahun')
                    ->options(list_tahun())
                    ->attribute('tahun')
                    ->searchable(),
                DateRangeFilter::make('created_at')
                    ->label('Rentang Tanggal'),
            ])->hiddenFilterIndicators()
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
                    ExportBulkAction::make()
                        ->label('Ekspor XLS yang dipilih')
                        ->color('primary')
                        ->icon('heroicon-o-arrow-up-tray')
                        ->exports([
                            ExportBantuanBpnt::make()
                                ->except(['created_at', 'updated_at', 'deleted_at']),
                        ]),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBantuanBpnt::route('/'),
            'create' => Pages\CreateBantuanBpnt::route('/create'),
            'view' => Pages\ViewBantuanBpnt::route('/{record}'),
            'edit' => Pages\EditBantuanBpnt::route('/{record}/edit'),
        ];
    }
}
