<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BantuanBpntResource\Pages;
use App\Filament\Resources\BantuanBpntResource\RelationManagers;
use App\Models\BantuanBpnt;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use AymanAlhattami\FilamentDateScopesFilter\DateScopeFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BantuanBpntResource extends Resource
{
    protected static ?string $model = BantuanBpnt::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $slug = 'bantuan-bpnt';
    protected static ?string $label = 'Bantuan BPNT';
    protected static ?string $pluralLabel = 'Bantuan BPNT';
    protected static ?string $navigationLabel = 'Bantuan BPNT';
    protected static ?string $navigationGroup = 'Bantuan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('attachment')
                    ->label('Impor')
                    ->hiddenLabel()
                    ->columnSpanFull()
                    ->preserveFilenames()
                    ->previewable(false)
                    ->directory('upload')
                    ->maxSize(5120)
                    ->reorderable()
                    ->appendFiles()
                    ->storeFiles(false)
                    ->acceptedFileTypes([
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'text/csv'
                    ])
                    ->visibleOn('create'),

                Section::make('Data Pribadi')->schema([
                    TextInput::make('dtks_id'),
                    TextInput::make('nokk'),
                    TextInput::make('nik_ktp'),
                    TextInput::make('nama_penerima'),
                ])
                    ->visibleOn(['edit', 'view'])
                    ->columns(2),

                Section::make('Data Bantuan')->schema([
                    TextInput::make('tahap'),
                    TextInput::make('bansos'),
                    TextInput::make('bank'),
                    TextInput::make('nominal'),
                    TextInput::make('dir'),
                    TextInput::make('gelombang'),
                ])
                    ->visibleOn(['edit', 'view'])
                    ->columns(2),

                Section::make('Data Alamat')->schema([
                    TextInput::make('alamat')->columnSpanFull(),
                    Grid::make()->schema([
                        Select::make('provinsi')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(Provinsi::pluck('name', 'code'))
                            ->afterStateUpdated(fn(callable $set) => $set('kabupaten', null)),

                        Select::make('kabupaten')
                            ->nullable()
                            ->options(function (callable $get) {
                                $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                                if (!$kab) {
                                    return Kabupaten::where('code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->reactive()
                            ->searchable()
//                            ->hidden(fn (callable $get) => ! $get('kecamatan'))
                            ->afterStateUpdated(fn(callable $set) => $set('kecamatan', null)),
                    ])->columns(2),

                    Grid::make()->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(function (callable $get) {
                                $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                if (!$kab) {
                                    return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
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
                            ->afterStateUpdated(function (callable $set, $state) {
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
                    ])->columns(2),

                    Grid::make()->schema([
                        TextInput::make('dusun'),
                        TextInput::make('no_rt'),
                        TextInput::make('no_rw'),
                    ])->columns(3),
                ])
                    ->visibleOn(['edit', 'view'])
                    ->columns(2)

            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('prov.name')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kab.name')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
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
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gelombang')
                    ->sortable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_bpnt')
                    ->label('Status')
                    ->badge()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                DateScopeFilter::make('created_at'),
            ])
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
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBantuanBpnt::route('/'),
        ];
    }
}