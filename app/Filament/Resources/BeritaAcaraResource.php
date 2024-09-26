<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BeritaAcaraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\BeritaAcara;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Supports\Helpers;
use Awcodes\Shout\Components\Shout;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
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
    protected static ?string $recordTitleAttribute = 'judul_ba';

    public static function table(Table $table): Table
    {

        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('judul_ba')
                    ->label('Judul')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_ba')
                    ->label('Tanggal Berita Acara')
                    ->toggleable()
                    ->date('l, d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kec.name')
                    ->label('Kecamatan')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kel.name')
                    ->label('Kelurahan')
                    ->sortable()
                    ->alignCenter()
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('itemBantuan.nama_barang')
                    ->label('Item Bantuan')
                    ->searchable()
                    ->alignCenter()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('penandatangan.nama_penandatangan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('bantuan_rastra_ids')
                    ->label('Jumlah KPM')
                    ->toggleable()
                    ->copyable()
                    ->alignCenter()
                    ->formatStateUsing(function ($state) {
                        $ids = explode(',', $state);
                        return BantuanRastra::whereIn('id', $ids)->count() . ' Orang';
                    }),
                Tables\Columns\TextColumn::make('upload_ba')
                    ->label('Berita Acara'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelurahan')
                    ->label('Kelurahan')
                    ->options(Kelurahan::query()->whereIn(
                        'kecamatan_code',
                        config('custom.kode_kecamatan'),
                    )->pluck('name', 'code'))
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->deferFilters()
            ->deferLoading()
            ->hiddenFilterIndicators()
            ->actions([
                Tables\Actions\Action::make('cetak')
                    ->label('Cetak Berita Acara')
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route('ba.rastra', ['id' => $record, 'm' => self::$model]))
                    ->form([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('beritaAcara'),
                            ]),
                    ])
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->closeModalByClickingAway(false),
                Tables\Actions\DeleteAction::make()->closeModalByClickingAway(false),
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
                Shout::make('so-important')
                    ->content('Sebelum mengisi form berita acara, harap mengisi terlebih dahulu penandatangan. Silahkan ke menu Dashboard Bantuan -> Penandatangan')
                    ->color(Color::Blue)
                    ->icon('heroicon-o-information-circle')
                    ->columnSpanFull(),
                Forms\Components\Section::make()
                    ->schema([
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
                            ->default(Str::upper(setting('ba.kop_ba', 'Berita Acara Serah Terima Barang')))
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('tgl_ba')
                            ->helperText(str('**Tanggal** terbit berita acara pada laporan.')->inlineMarkdown()->toHtmlString())
                            ->label('Tanggal Berita Acara')
                            ->required()
                            ->default(today())
                            ->displayFormat('d/m/y'),
                        Forms\Components\Select::make('penandatangan_id')
                            ->relationship(
                                name: 'penandatangan',
                                titleAttribute: 'nama_penandatangan',
                                modifyQueryUsing: fn(Builder $query) => $query->with(['kecamatan', 'kelurahan']),
                            )
                            ->native(false)
                            ->noSearchResultsMessage('Data KPM Rastra tidak ditemukan')
                            ->searchPrompt('Cari Penandatangan')
                            ->getOptionLabelFromRecordUsing(
                                fn(
                                    Model $record,
                                ) => "<strong>{$record->nama_penandatangan}</strong><br>{$record->jabatan->value} - {$record->kelurahan?->name}",
                            )
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('kecamatan')
                            ->required()
                            ->searchable()
                            ->live(onBlur: true)
                            ->noSearchResultsMessage('Kecamatan tidak ditemukan')
                            ->searchPrompt('Cari Kecamatan')
                            ->options(function () {
                                $kab = Kecamatan::query()->where(
                                    'kabupaten_code',
                                    setting('app.kodekab', config('custom.default.kodekab')),
                                );
                                if ( ! $kab) {
                                    return Kecamatan::where(
                                        'kabupaten_code',
                                        setting('app.kodekab', config('custom.default.kodekab')),
                                    )
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->required()
                            ->noSearchResultsMessage('Kelurahan tidak ditemukan')
                            ->searchPrompt('Cari Kelurahan')
                            ->options(function (callable $get) {
                                return Kelurahan::query()->where(
                                    'kecamatan_code',
                                    $get('kecamatan'),
                                )?->pluck(
                                    'name',
                                    'code',
                                );
                            })
                            ->searchable()
                            ->live(onBlur: true),
                        Forms\Components\Select::make('barang_id')
                            ->label('Item Bantuan')
                            ->relationship(
                                name: 'itemBantuan',
                                titleAttribute: 'nama_barang',
                            )
                            ->native(false)
                            ->preload()
                            ->getOptionLabelFromRecordUsing(
                                fn(
                                    Model $record,
                                ) => "<strong>{$record->nama_barang}</strong> - {$record->kel?->name}",
                            )
                            ->allowHtml()
                            ->searchable()
                            ->noSearchResultsMessage('Item tidak ditemukan')
                            ->searchPrompt('Cari Item Bantuan')
                            ->required(),

                        Forms\Components\FileUpload::make('upload_ba')
                            ->label('Upload Berita Acara')
                            ->maxSize(1024 * 5),

                        Forms\Components\Textarea::make('keterangan')
                            ->autosize()
                            ->grow()
                            ->nullable()
                            ->columnSpanFull()
                            ->default(null),
                    ])->columns(2),

            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(superadmin_admin_roles())) {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()
            ->where('kelurahan', auth()->user()->instansi_id);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBeritaAcaras::route('/'),
        ];
    }
}
