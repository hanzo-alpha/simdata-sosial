<?php

namespace App\Filament\Resources;

use App\Enums\StatusPenyaluran;
use App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;
use App\Models\BantuanRastra;
use App\Models\PenyaluranBantuanRastra;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PenyaluranBantuanRastraResource extends Resource
{
    protected static ?string $model = PenyaluranBantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $slug = 'penyaluran-bantuan-rastra';
    protected static ?string $label = 'Penyaluran Rastra';
    protected static ?string $pluralLabel = 'Penyaluran Rastra';
    protected static ?string $navigationParentItem = 'Program Rastra';
    protected static ?string $navigationGroup = 'Program Sosial';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('bantuan_rastra_id')
                            ->label('Nama KPM')
                            ->relationship('bantuan_rastra', 'nama_lengkap')
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
                                callable $set
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
                                callable $set
                            ): void {
                                $set('location', [
                                    'lat' => (float) $get('lat'),
                                    'lng' => (float) $state,
                                ]);
                            })
                            ->lazy(),

                    ])->columns(2),
                ])->columnSpan(2),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\DateTimePicker::make('tgl_penyerahan')
                            ->label('Tgl. Penyerahan')
                            ->disabled()
                            ->default(now())
                            ->dehydrated(),
                        Forms\Components\Select::make('status_penyaluran')
                            ->label('Status Penyaluran Bantuan')
                            ->options(StatusPenyaluran::class)
                            ->lazy()
                            ->preload(),
                        Forms\Components\FileUpload::make('foto_penyerahan')
                            ->label('Foto Penyerahan')
                            ->disk('public')
                            ->directory('penyaluran')
                            ->required()
                            ->getUploadedFileNameForStorageUsing(
                                fn(
                                    TemporaryUploadedFile $file
                                ): string => (string) str($file->getClientOriginalName())
                                    ->prepend(date('YmdHis') . '-'),
                            )
                            ->preserveFilenames()
//                                ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->openable()
                            ->unique(ignoreRecord: true)
                            ->helperText('maks. 2MB')
                            ->maxFiles(3)
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->imagePreviewHeight('250')
                            ->previewable(true)
                            ->image(),
                        //                        Forms\Components\FileUpload::make('foto_ktp_kk')
                        //                            ->label('Foto KTP / KK')
                        //                            ->disk('public')
                        //                            ->directory('penyaluran')
                        //                            ->required()
                        //                            ->getUploadedFileNameForStorageUsing(
                        //                                fn(
                        //                                    TemporaryUploadedFile $file
                        //                                ): string => (string) str($file->getClientOriginalName())
                        //                                    ->prepend(date('YmdHis') . '-'),
                        //                            )
                        //                            ->preserveFilenames()
                        ////                                ->multiple()
                        //                            ->reorderable()
                        //                            ->appendFiles()
                        //                            ->openable()
                        //                            ->unique(ignoreRecord: true)
                        //                            ->helperText('maks. 2MB')
                        //                            ->maxFiles(3)
                        //                            ->maxSize(2048)
                        //                            ->columnSpanFull()
                        //                            ->imagePreviewHeight('250')
                        //                            ->previewable(true)
                        //                            ->image(),
                    ]),
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //                Tables\Columns\ImageColumn::make('foto_penyerahan'),
                //                Tables\Columns\ImageColumn::make('foto_ktp_kk'),
                Tables\Columns\TextColumn::make('bantuan_rastra.nama_lengkap')
                    ->label('Nama KPM')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nokk')
                    ->label('No. KK KPM')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bantuan_rastra.nik')
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

            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('Print Dokumentasi')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Model $record) => route('pdf.rastra', ['id' => $record, 'm' => self::$model]))
                    ->openUrlInNewTab(),
                Tables\Actions\ActionGroup::make([
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
}
