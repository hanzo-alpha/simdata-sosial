<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlamatResource\Pages;
use App\Filament\Resources\AlamatResource\RelationManagers;
use App\Models\Alamat;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AlamatResource extends Resource
{
    protected static ?string $model = Alamat::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $slug = 'alamat';
    protected static ?string $label = 'Alamat';
    protected static ?string $pluralLabel = 'Alamat';
    protected static ?string $navigationGroup = 'Master';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        Geocomplete::make('alamat')
                            ->countries(['id'])
                            ->updateLatLng()
                            ->geocodeOnLoad()
                            ->columnSpanFull()
                            ->reverseGeocode([
                                'country' => '%C',
                                'city' => '%L',
                                'district' => '%D',
                                'zip' => '%z',
                                'state' => '%A1',
                                'street' => '%S %n',
                            ]),

//                    Map::make('location')
//                        ->mapControls([
//                            'mapTypeControl' => true,
//                            'scaleControl' => true,
//                            'streetViewControl' => true,
//                            'rotateControl' => true,
//                            'fullscreenControl' => true,
//                            'searchBoxControl' => false, // creates geocomplete field inside map
//                            'zoomControl' => false,
//                        ])
//                        ->height(fn() => '400px')
//                        ->autocomplete(fieldName: 'full_address', countries: ['id'])
//                        ->autocompleteReverse(true)
//                        ->draggable()
//                        ->clickable()
//                        ->geolocate()
//                        ->reverseGeocode([
//                            'city' => '%L',
//                            'zip' => '%z',
//                            'state' => '%A1',
//                            'street' => '%n %S',
//                        ])
//                        ->defaultLocation([-4.366561933335206, 119.89695254227935])
//                        ->defaultZoom(16)
//                        ->columnSpan('full')
//                        ->live(true)
//                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
//                            $set('latitude', $state['lat']);
//                            $set('longitude', $state['lng']);
//                        }),
//                    TextInput::make('alamat')->nullable(),
                        Grid::make(2)->schema([
                            TextInput::make('latitude')
                                ->live(true)
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $set('location', [
                                        'lat' => floatVal($state),
                                        'lng' => (float) $get('longitude'),
                                    ]);
                                })
                                ->lazy(), // important to use lazy, to avoid updates as you type
                            TextInput::make('longitude')
                                ->live(true)
                                ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                    $set('location', [
                                        'lat' => (float) $get('latitude'),
                                        'lng' => floatVal($state),
                                    ]);
                                })
                                ->lazy(),
                        ]),
                    ]),

//            Grid::make(2)
//                ->schema([
//                    Select::make('provinsi')
//                        ->searchable()
//                        ->options(Provinsi::pluck('name', 'code'))
//                        ->default(config('custom.default.kodeprov'))
//                        ->preload()
//                        ->live(true)
//                        ->optionsLimit(20)
//                        ->label('Provinsi'),
//                    Select::make('kabupaten')
//                        ->nullable()
//                        ->options(function (callable $get) {
//                            $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
//                            $kab = $kab ?? config('custom.default.kodeprov');
//                            if (!$kab) {
//                                return Kabupaten::where('provinsi_code', config('custom.default.kodekab'))
//                                    ->pluck('name', 'code');
//                            }
//
//                            return $kab->pluck('name', 'code');
//                        })
//                        ->afterStateUpdated(fn(callable $set) => $set('kecamatan', null))
//                        ->reactive()
//                        ->searchable(),
//                ]),

                Grid::make(2)
                    ->schema([
                        Select::make('kecamatan')
                            ->nullable()
                            ->searchable()
                            ->reactive()
                            ->options(function (callable $get) {
//                            $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                                $kab = Kecamatan::query()->where('kabupaten_code', config('custom.default.kodekab'));
                                if (!$kab) {
                                    return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
                                        ->pluck('name', 'code');
                                }

                                return $kab->pluck('name', 'code');
                            })
//                            ->hidden(fn (callable $get) => ! $get('kabupaten'))
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
                    ]),

                Grid::make(4)
                    ->schema([
                        TextInput::make('dusun')
                            ->label('Dusun'),
                        TextInput::make('no_rt')
                            ->label('RT'),
                        TextInput::make('no_rw')
                            ->label('RW'),
                        TextInput::make('kodepos')
                            ->label('Kodepos'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('keluarga_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('alamat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_rw')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kelurahan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dusun')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kodepos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAlamats::route('/'),
            'create' => Pages\CreateAlamat::route('/create'),
            'edit' => Pages\EditAlamat::route('/{record}/edit'),
        ];
    }
}
