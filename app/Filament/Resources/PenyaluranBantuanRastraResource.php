<?php

namespace App\Filament\Resources;

use App\Enums\StatusPenyaluran;
use App\Filament\Resources\PenyaluranBantuanRastraResource\Pages;
use App\Filament\Resources\PenyaluranBantuanRastraResource\RelationManagers;
use App\Models\BantuanRastra;
use App\Models\PenyaluranBantuanRastra;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PenyaluranBantuanRastraResource extends Resource
{
    protected static ?string $model = PenyaluranBantuanRastra::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $slug = 'penyaluran-bantuan-rastra';
    protected static ?string $label = 'Penyaluran Rastra';
    protected static ?string $pluralLabel = 'Penyaluran Rastra';
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
                            ->preload()
                            ->getOptionLabelFromRecordUsing(function (Model $record) {
                                return "<strong>{$record->nama_lengkap}</strong><br> {$record->nik}";
                            })
                            ->allowHtml()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $rastra = BantuanRastra::find($state);

                                $set('nik', $rastra->nik);
                                $set('nokk', $rastra->nokk);
                            })
                            ->columnSpanFull()
                            ->helperText(str('**Nama KPM** disini, termasuk dengan NIK.')->inlineMarkdown()->toHtmlString())
                            ->optionsLimit(20),
                        Forms\Components\TextInput::make('nokk')
                            ->label('NO KK')
                            ->disabled(),
                        Forms\Components\TextInput::make('nik')
                            ->label('NIK KPM')
                            ->disabled(),
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
                            ->disabled()
                            ->reactive()
                            ->afterStateUpdated(function (
                                $state,
                                callable $get,
                                callable $set
                            ) {
                                $set('location', [
                                    'lat' => floatVal($state),
                                    'lng' => floatVal($get('lng')),
                                ]);
                            })
                            ->lazy(), // important to use lazy, to avoid updates as you type
                        TextInput::make('lng')
                            ->disabled()
                            ->reactive()
                            ->afterStateUpdated(function (
                                $state,
                                callable $get,
                                callable $set
                            ) {
                                $set('location', [
                                    'lat' => (float) $get('lat'),
                                    'lng' => floatVal($state),
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
                            ->options(StatusPenyaluran::class)
                            ->lazy()
                            ->preload(),
                        Forms\Components\FileUpload::make('foto_penyerahan')
                            ->disk('public')
                            ->directory('penyaluran')
                            ->required()
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file
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
                        Forms\Components\FileUpload::make('foto_ktp_kk')
                            ->disk('public')
                            ->directory('penyaluran')
                            ->required()
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file
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
                            ->image()
                    ])
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
                    ->dateTime()
                    ->formatStateUsing(fn($record) => $record->tgl_penyerahan->format('d F Y H:i:s'))
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Alamat')
                    ->limit(30),
                Tables\Columns\TextColumn::make('status_penyaluran')
                    ->label('Status')
                    ->alignCenter()
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            //
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
