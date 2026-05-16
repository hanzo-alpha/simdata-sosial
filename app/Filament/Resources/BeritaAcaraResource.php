<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StatusAktif;
use App\Filament\Resources\BeritaAcaraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\BeritaAcara;
use App\Supports\Helpers;
use Awcodes\Shout\Components\Shout;
use BackedEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use UnitEnum;

class BeritaAcaraResource extends Resource
{
    protected static ?string $model = BeritaAcara::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'berita-acara';
    protected static ?string $label = 'Berita Acara Rastra';
    protected static ?string $pluralLabel = 'Berita Acara Rastra';
    protected static ?string $navigationParentItem = 'Program Rastra';
    protected static string|UnitEnum|null $navigationGroup = 'Program Bantuan';
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
                    ->state(fn(BeritaAcara $record): string => count($record->bantuan_rastra_ids ?? []) . ' Orang')
                    ->copyable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('upload_ba')
                    ->label('Berita Acara'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kelurahan')
                    ->label('Kelurahan')
                    ->options(get_kelurahan_options())
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->deferFilters()
            ->deferLoading()
            ->hiddenFilterIndicators()
            ->recordActions([
                Actions\Action::make('cetak')
                    ->label('Cetak Berita Acara')
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route('ba.rastra', ['id' => $record, 'm' => self::$model]))
                    ->schema([
                        Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('beritaAcara'),
                            ]),
                    ])
                    ->openUrlInNewTab(),
                Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        $bantuan = BantuanRastra::query()
                            ->where('kecamatan', $data['kecamatan'])
                            ->where('kelurahan', $data['kelurahan'])
                            ->where('status_aktif', StatusAktif::AKTIF)
                            ->get();

                        $data['bantuan_rastra_ids'] = $bantuan->pluck('id');
                        $record->update($data);

                        return $record;
                    })
                    ->closeModalByClickingAway(false),
                Actions\DeleteAction::make()->closeModalByClickingAway(false),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make()
                        ->after(fn(\Illuminate\Support\Collection $records) => activity()
                            ->log('Hapus masal ' . $records->count() . ' data berita acara rastra')),
                ]),
            ]);
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Shout::make('so-important')
                    ->content('Sebelum mengisi form berita acara, harap mengisi terlebih dahulu penandatangan. Silahkan ke menu Dashboard Bantuan -> Penandatangan')
                    ->color(Color::Blue)
                    ->icon('heroicon-o-information-circle')
                    ->columnSpanFull(),
                Section::make()
                    ->columnSpanFull()
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
                            ->options(get_kecamatan_options())
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->required()
                            ->noSearchResultsMessage('Kelurahan tidak ditemukan')
                            ->searchPrompt('Cari Kelurahan')
                            ->options(fn(callable $get) => get_kelurahan_options($get('kecamatan')))
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
                                fn(Model $record) => "<strong>{$record->nama_barang}</strong> - {$record->kel?->name}",
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
        return parent::getEloquentQuery();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBeritaAcaras::route('/'),
        ];
    }
}
