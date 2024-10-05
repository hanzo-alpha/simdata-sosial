<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\StatusPenyaluran;
use App\Filament\Resources\PenyaluranBantuanPpksResource\Pages;
use App\Models\BantuanPpks;
use App\Models\PenyaluranBantuanPpks;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenyaluranBantuanPpksResource extends Resource
{
    protected static ?string $model = PenyaluranBantuanPpks::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'penyaluran-bantuan-ppks';
    protected static ?string $label = 'Penyaluran PPKS';
    protected static ?string $pluralLabel = 'Penyaluran PPKS';
    protected static ?string $navigationParentItem = 'Program PPKS';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make()->schema([
                        Select::make('bantuan_ppks_id')
                            ->label('Nama KPM')
                            ->relationship('bantuan_ppks', 'nama_lengkap')
                            ->native(false)
                            ->searchable(['nama_lengkap', 'nik', 'nokk'])
                            ->noSearchResultsMessage('Data KPM Rastra tidak ditemukan')
                            ->searchPrompt('Cari KPM berdasarkan no.kk , nik, atau nama')
                            ->getOptionLabelFromRecordUsing(fn(
                                Model $record,
                            ) => "<strong>{$record->nama_lengkap}</strong><br> {$record->nik}")
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Set $set): void {
                                $rastra = BantuanPpks::find($state);

                                if (isset($rastra) && $rastra->count() > 0) {
                                    $set('nik', $rastra->nik);
                                    $set('no_kk', $rastra->nokk);
                                } else {
                                    $set('nik', null);
                                    $set('no_kk', null);
                                }
                            })
                            ->columnSpanFull()
                            ->helperText(str('**Nama KPM** disini, termasuk dengan NIK.')->inlineMarkdown()->toHtmlString())
                            ->optionsLimit(20),
                        TextInput::make('no_kk')
                            ->label('NO KK')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('nik')
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

                    ])->columns(2),
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make()->schema([
                        DateTimePicker::make('tgl_penyerahan')
                            ->label('Tgl. Penyerahan')
                            ->default(now()),
                        Select::make('status_penyaluran')
                            ->label('Status Penyaluran Bantuan')
                            ->options(StatusPenyaluran::class)
                            ->lazy()
                            ->preload(),
                        FileUpload::make('foto_penyerahan')
                            ->label('Foto Penyerahan')
                            ->disk('public')
                            ->directory('penyaluran-ppks')
                            ->required()
                            ->multiple()
                            ->openable()
                            ->unique(ignoreRecord: true)
                            ->helperText('maks. 10MB')
                            ->maxFiles(2)
                            ->maxSize(10240)
                            ->columnSpanFull()
                            ->imagePreviewHeight('250')
                            ->previewable(true)
                            ->image()
                            ->imageEditor(),
                    ]),
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon('heroicon-o-information-circle')
            ->emptyStateHeading('Belum ada penyaluran bantuan PPKS')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah')
                    ->icon('heroicon-m-plus')
                    ->disabled(fn() => cek_batas_input(setting('app.batas_tgl_input_ppks')))
                    ->button(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('bantuan_ppks.nama_lengkap')
                    ->label('Nama KPM')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_ppks.nokk')
                    ->label('No. KK KPM')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_ppks.nik')
                    ->label('NIK KPM')
                    ->searchable()
                    ->alignCenter()
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
                Tables\Columns\TextColumn::make('status_penyaluran')
                    ->label('Status')
                    ->alignCenter()
                    ->badge(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('Print Dokumentasi')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route('cetak-dokumentasi.ppks', ['id' => $record, 'm' => self::$model]))
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

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenyaluranBantuanPpks::route('/'),
            'create' => Pages\CreatePenyaluranBantuanPpks::route('/create'),
            'edit' => Pages\EditPenyaluranBantuanPpks::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(superadmin_admin_roles())) {
            return parent::getEloquentQuery()
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return parent::getEloquentQuery()
            ->whereHas('bantuan_ppks', fn(Builder $query) => $query->where('kelurahan', auth()->user()->instansi_id))
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
