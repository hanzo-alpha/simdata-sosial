<?php

namespace App\Filament\Resources;

use App\Enums\StatusAktif;
use App\Filament\Resources\BeritaAcaraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\BeritaAcara;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Supports\Helpers;
use Awcodes\TableRepeater\Components\TableRepeater;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Str;

class BeritaAcaraResource extends Resource
{
    protected static ?string $model = BeritaAcara::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'berita-acara';
    protected static ?string $label = 'Berita Acara Rastra';
    protected static ?string $pluralLabel = 'Berita Acara Rastra';
    protected static ?string $navigationParentItem = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 8;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bantuan_rastra.nama_lengkap')
                    ->label('Nama KPM')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nik')
                    ->label('NIK KPM')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul_ba')
                    ->label('Judul')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_ba')
                    ->label('Tanggal Berita Acara')
                    ->toggleable()
                    ->date('l, d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('itemBantuan.nama_barang')
                    ->label('Jenis Bantuan')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('penandatangan.nama_penandatangan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\Action::make('cetak')
                    ->label('Cetak Berita Acara')
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route('pdf.ba', ['id' => $record, 'm' => self::$model]))
                    ->form([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('beritaAcara')
                            ])
                    ])
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('bantuan_rastra_id')
                            ->label('Nama KPM')
                            ->required()
                            ->relationship('bantuan_rastra', 'nama_lengkap', modifyQueryUsing: fn(
                                Builder $query
                            ) => $query->where('status_aktif', '=', StatusAktif::AKTIF))
                            ->native(false)
                            ->searchable(['nama_lengkap', 'nik', 'nokk'])
                            ->noSearchResultsMessage('Data KPM Rastra tidak ditemukan')
                            ->searchPrompt('Cari KPM berdasarkan no.kk , nik, atau nama')
                            ->getOptionLabelFromRecordUsing(fn(
                                Model $record
                            ) => "<strong>{$record->nama_lengkap}</strong><br> {$record->nik}")
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set): void {
                                $rastra = BantuanRastra::find($state);

                                if (isset($rastra) && $rastra->count() > 0) {
                                    $set('kecamatan', $rastra->kecamatan);
                                    $set('kelurahan', $rastra->kelurahan);
                                } else {
                                    $set('kecamatan', null);
                                    $set('kelurahan', null);
                                }
                            })
                            ->columnSpanFull()
                            ->helperText(str('**Nama KPM** disini, termasuk dengan NIK.')->inlineMarkdown()->toHtmlString())
                            ->optionsLimit(20),
                        Forms\Components\TextInput::make('nomor_ba')
                            ->label('Nomor Berita Acara')
                            ->helperText(str('**Nomor Berita Acara** pada laporan Berita Acara.')
                                ->inlineMarkdown()
                                ->toHtmlString())
                            ->required()
                            ->default(Helpers::generateNoSuratBeritaAcara())
                            ->maxLength(255),
                        Forms\Components\TextInput::make('judul_ba')
                            ->helperText(str('**Judul Berita Acara** dalam laporan Berita Acara.')
                                ->inlineMarkdown()
                                ->toHtmlString())
                            ->label('Judul Berita Acara')
                            ->required()
                            ->default(Str::upper('Berita Acara Serah Terima Barang'))
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tgl_ba')
                            ->helperText(str('**Tanggal** terbit berita acara pada laporan.')->inlineMarkdown()->toHtmlString())
                            ->label('Tanggal Berita Acara')
                            ->label('Tanggal Berita Acara')
                            ->default(today())
                            ->displayFormat('d/m/y'),
                        Select::make('kecamatan')
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->options(function () {
                                $kab = Kecamatan::query()->where(
                                    'kabupaten_code',
                                    setting('app.kodekab', config('custom.default.kodekab'))
                                );
                                if (!$kab) {
                                    return Kecamatan::where(
                                        'kabupaten_code',
                                        setting('app.kodekab', config('custom.default.kodekab'))
                                    )
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->required()
                            ->options(function (callable $get) {
                                return Kelurahan::query()->where(
                                    'kecamatan_code',
                                    $get('kecamatan')
                                )?->pluck(
                                    'name',
                                    'code'
                                );
                            })
                            ->reactive()
                            ->searchable(),
                        Forms\Components\Select::make('barang_id')
                            ->label('Item Bantuan')
                            ->nullable()
                            ->hidden()
                            ->helperText(str('**Item** bantuan pada laporan.')->inlineMarkdown()->toHtmlString())
                            ->relationship('barang', 'nama_barang')
                            ->native(false)
                            ->preload()
                            ->dehydrated()
                            ->searchable()
                            ->noSearchResultsMessage('Data KPM Rastra tidak ditemukan')
                            ->searchPrompt('Cari Item Bantuan')
                            ->getOptionLabelFromRecordUsing(
                                fn(
                                    Model $record
                                ) => "<strong>{$record->nama_barang}</strong><br> {$record->kode_barang}"
                            )
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->required(),
                        Forms\Components\Select::make('penandatangan_id')
                            ->relationship(
                                name: 'penandatangan',
                                titleAttribute: 'nama_penandatangan',
                                modifyQueryUsing: function (Builder $query) {
                                    if (!auth()->user()->hasRole('super_admin')) {
                                        return $query->where('kode_instansi', auth()->user()->instansi_id);
                                    }
                                    return $query->with(['kecamatan', 'kelurahan']);

                                }
                            )
                            ->native(false)
                            ->noSearchResultsMessage('Data KPM Rastra tidak ditemukan')
                            ->searchPrompt('Cari Penandatangan')
                            ->getOptionLabelFromRecordUsing(
                                fn(Model $record) => "<strong>{$record->nama_penandatangan}</strong><br>
                            {$record->jabatan} - {$record->kelurahan->name}"
                            )
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->preload()
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('keterangan')
                            ->maxLength(255)
                            ->default(null),
                    ])->columns(2),

                Forms\Components\Grid::make()
                    ->hiddenLabel()
                    ->schema([
                        TableRepeater::make('itemBantuan')
                            ->relationship('itemBantuan')
                            ->columnSpanFull()
                            ->label('Item Bantuan Rastra')
                            ->headers([
                                \Awcodes\TableRepeater\Header::make('Kode Item')
                                    ->markAsRequired(),
                                \Awcodes\TableRepeater\Header::make('Nama Item')
                                    ->markAsRequired(),
                                \Awcodes\TableRepeater\Header::make('Qty')
                                    ->markAsRequired(),
                                \Awcodes\TableRepeater\Header::make('Satuan')
                                    ->markAsRequired(),
                                \Awcodes\TableRepeater\Header::make('Harga')
                                    ->markAsRequired(),
                                \Awcodes\TableRepeater\Header::make('Total')
                                    ->markAsRequired(),
                                \Awcodes\TableRepeater\Header::make('Ket'),
                            ])
                            ->emptyLabel('Tidak ada item ditemukan.')
                            ->streamlined()
                            ->schema([
                                Forms\Components\TextInput::make('kode_barang')
                                    ->required()
                                    ->default(Helpers::generateKodeBarang())
                                    ->disabled()
                                    ->dehydrated()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nama_barang')
                                    ->required()
                                    ->default('Beras')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('kuantitas')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\TextInput::make('satuan')
                                    ->maxLength(255)
                                    ->default(null),
                                Forms\Components\TextInput::make('harga_satuan')
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, $state): void {
                                        $set('total_harga', $state * $get('kuantitas'));
                                    })
                                    ->default(0),
                                Forms\Components\TextInput::make('total_harga')
                                    ->numeric()
                                    ->default(0),
                                Forms\Components\Textarea::make('keterangan')
                                    ->nullable()
                                    ->columnSpanFull(),
                            ]),
                    ])

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBeritaAcaras::route('/'),
        ];
    }
}
