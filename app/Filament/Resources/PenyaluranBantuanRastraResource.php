<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StatusAktif;
use App\Enums\StatusPenyaluran;
use App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\Kelurahan;
use App\Models\PenyaluranBantuanRastra;
use App\Traits\HasInputDateLimit;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PenyaluranBantuanRastraResource extends Resource
{
    use HasInputDateLimit;

    protected static ?string $model = PenyaluranBantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'penyaluran-bantuan-rastra';
    protected static ?string $label = 'Penyaluran Rastra';
    protected static ?string $pluralLabel = 'Penyaluran Rastra';
    protected static ?string $navigationParentItem = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 7;

    public static function getGloballySearchableAttributes(): array
    {
        return ['bantuan_rastra.nama_lengkap', 'bantuan_rastra.nokk', 'bantuan_rastra.nik'];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->poll()
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada penyaluran bantuan RASTRA')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn() => cek_batas_input(setting('app.batas_tgl_input_rastra')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('bantuan_rastra.nama_lengkap')
                    ->label('Nama KPM')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nokk')
                    ->label('No. KK KPM')
                    ->searchable()
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nik')
                    ->label('NIK KPM')
                    ->searchable()
                    ->alignCenter()
                    ->formatStateUsing(fn($state) => Str::mask($state, '*', 2, 12))
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_penyerahan')
                    ->label('Penyerahan')
                    ->dateTime()
                    ->formatStateUsing(fn($record) => $record->tgl_penyerahan->diffForHumans())
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Alamat')
                    ->limit(30),
                CuratorColumn::make('beritaAcara')
                    ->label('Berita Acara')
                    ->size(60),
                Tables\Columns\TextColumn::make('status_penyaluran')
                    ->label('Status')
                    ->alignCenter()
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\Filter::make('filter_kel')
                    ->label('Kelurahan')
                    ->form([
                        Forms\Components\Select::make('kelurahan')
                            ->label('Kelurahan')
                            ->native(false)
                            ->options(Kelurahan::query()
                                ->whereIn('kecamatan_code', config('custom.kode_kecamatan'))
                                ->pluck('name', 'code'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query->with('bantuan_rastra')->when(
                        $data['kelurahan'],
                        fn(Builder $query, $data) => $query->whereRelation(
                            'bantuan_rastra',
                            'kelurahan',
                            $data,
                        ),
                    )),
                Tables\Filters\TrashedFilter::make(),

            ])
            ->actions([
                Tables\Actions\Action::make('cetak_dokumentasi')
                    ->label('Cetak Dokumentasi')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route(
                        'cetak-dokumentasi.rastra',
                        ['id' => $record, 'm' => self::$model],
                    ))
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
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
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('bantuan_rastra_id')
                            ->label('Nama KPM')
                            ->required()
                            ->relationship('bantuan_rastra', 'nama_lengkap', modifyQueryUsing: fn(
                                Builder $query,
                            ) => $query->when(auth()->user()->instansi_id, fn(Builder $query) => $query->where('kelurahan', auth()->user()->instansi_id))
                                ->where('status_aktif', '=', StatusAktif::AKTIF))
                            ->native(false)
                            ->searchable(['nama_lengkap', 'nik', 'nokk'])
                            ->noSearchResultsMessage('Data KPM Rastra tidak ditemukan')
                            ->searchPrompt('Cari KPM berdasarkan no.kk , nik, atau nama')
                            ->getOptionLabelFromRecordUsing(fn(
                                Model $record,
                            ) => "<strong>{$record->nama_lengkap}</strong><br> {$record->nik}")
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set): void {
                                $rastra = BantuanRastra::find($state);

                                if (isset($rastra) && $rastra->count() > 0) {
                                    $set('nik_kpm', $rastra->nik);
                                    $set('no_kk', $rastra->nokk);
                                } else {
                                    $set('nik_kpm', null);
                                    $set('no_kk', null);
                                }
                            })
                            ->columnSpanFull()
                            ->helperText(str('**Nama KPM** disini, termasuk dengan NIK.')->inlineMarkdown()->toHtmlString())
                            ->optionsLimit(20),
                        Forms\Components\TextInput::make('no_kk')
                            ->label('NO KK')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('nik_kpm')
                            ->label('NIK KPM')
                            ->disabled()
                            ->dehydrated(),
                        Geocomplete::make('lokasi')
                            ->required()
                            ->countries(['id'])
                            ->updateLatLng()
                            ->geocodeOnLoad()
                            ->geolocate()
                            ->columnSpanFull()
                            ->reverseGeocode([
                                'country' => '%C',
                                'city' => '%L',
                                'city_district' => '%D',
                                'zip' => '%z',
                                'state' => '%A1',
                                'street' => '%S %n',
                            ]),
                        TextInput::make('lat')
                            ->label('Latitude')
                            ->disabled()
                            ->reactive()
                            ->dehydrated()
                            ->afterStateUpdated(function (
                                $state,
                                callable $get,
                                callable $set,
                            ): void {
                                $set('location', [
                                    'lat' => (float) $state,
                                    'lng' => (float) ($get('lng')),
                                ]);
                            })
                            ->lazy(), // important to use lazy, to avoid updates as you type
                        TextInput::make('lng')
                            ->label('Longitude')
                            ->disabled()
                            ->reactive()
                            ->dehydrated()
                            ->afterStateUpdated(function (
                                $state,
                                callable $get,
                                callable $set,
                            ): void {
                                $set('location', [
                                    'lat' => (float) $get('lat'),
                                    'lng' => (float) $state,
                                ]);
                            })
                            ->lazy(),

                        TextInput::make('keterangan')
                            ->nullable()
                            ->columnSpanFull(),

                    ])->columns(2),
                ])->columnSpan(2),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\DateTimePicker::make('tgl_penyerahan')
                            ->label('Tgl. Penyerahan')
                            ->displayFormat('d/M/Y H:i:s')
                            ->default(now()),
                        Forms\Components\Select::make('status_penyaluran')
                            ->label('Status Penyaluran Bantuan')
                            ->options(StatusPenyaluran::class)
                            ->default(StatusPenyaluran::TERSALURKAN)
                            ->lazy()
                            ->preload(),
                        Forms\Components\FileUpload::make('foto_penyerahan')
                            ->label('Foto Penyerahan')
                            ->disk('public')
                            ->directory('penyaluran')
                            ->image()
                            ->required()
                            ->imagePreviewHeight('250')
                            ->multiple()
                            ->imageEditor()
                            ->openable()
                            ->helperText('maks. 10MB')
                            ->maxFiles(2)
                            ->maxSize(10240)
                            ->columnSpanFull()
                            ->previewable(true),

                        CuratorPicker::make('media_id')
                            ->label('Upload Berita Acara')
                            ->buttonLabel('Tambah File')
                            ->relationship('beritaAcara', 'pretty_name')
                            ->nullable()
                            ->preserveFilenames()
                            ->columnSpanFull(),
                    ]),
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenyaluranBantuanRastra::route('/'),
            'create' => Pages\CreatePenyaluranBantuanRastra::route('/create'),
            'edit' => Pages\EditPenyaluranBantuanRastra::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(superadmin_admin_roles())) {
            return parent::getEloquentQuery()
                ->with(['beritaAcara'])
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery()
            ->with(['beritaAcara'])
            ->whereHas('bantuan_rastra', fn(Builder $query) => $query->where('kelurahan', auth()->user()->instansi_id))
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
