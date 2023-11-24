<?php

namespace App\Forms\Components;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class AlamatForm extends Field
{
    public ?string $relationship = null;

    protected string $view = 'filament-forms::components.group';

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $record = $this->getRecord();
        $relationship = $record?->{$this->getRelationship()}();

        if ($relationship === null) {
            return;
        }

        if ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record?->touch();
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }

    public function getChildComponents(): array
    {
        return [
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
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AlamatForm $component, ?Model $record) {
            $address = $record?->getRelationValue($this->getRelationship());

            $component->state($address ? $address->toArray() : [
                'provinsi' => null,
                'alamat' => null,
                'kabupaten' => null,
                'kecamatan' => null,
                'kelurahan' => null,
                'no_rt' => null,
                'no_rw' => null,
                'dusun' => null,
                'kodepos' => null,
            ]);
        });

        $this->dehydrated(false);
    }
}
