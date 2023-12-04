<?php

namespace App\Forms\Components;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
//            Grid::make()
//                ->schema([
//                    Geocomplete::make('alamat')
//                        ->countries(['id'])
//                        ->updateLatLng()
//                        ->geocodeOnLoad()
//                        ->columnSpanFull()
//                        ->reverseGeocode([
//                            'country' => '%C',
//                            'city' => '%L',
//                            'city_district' => '%D',
//                            'zip' => '%z',
//                            'state' => '%A1',
//                            'street' => '%S %n',
//                        ]),
//                    Grid::make(2)->schema([
//                        TextInput::make('latitude')
//                            ->disabled()
//                            ->dehydrated()
//                            ->reactive()
//                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
//                                $set('location', [
//                                    'lat' => floatVal($state),
//                                    'lng' => floatVal($get('longitude')),
//                                ]);
//                            })
//                            ->lazy(), // important to use lazy, to avoid updates as you type
//                        TextInput::make('longitude')
//                            ->disabled()
//                            ->dehydrated()
//                            ->reactive()
//                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
//                                $set('location', [
//                                    'lat' => (float) $get('latitude'),
//                                    'lng' => floatVal($state),
//                                ]);
//                            })
//                            ->lazy(),
//                    ]),
//                ]),
            Grid::make(2)
                ->schema([
                    TextInput::make('alamat')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('kecamatan')
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function () {
                            $kab = Kecamatan::query()->where('kabupaten_code', config('custom.default.kodekab'));
                            if (!$kab) {
                                return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
                                    ->pluck('name', 'code');
                            }

                            return $kab->pluck('name', 'code');
                        })
                        ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                    Select::make('kelurahan')
                        ->required()
                        ->options(function (callable $get) {
                            $kel = Kelurahan::query()->where('kecamatan_code', $get('kecamatan'));
                            if (!$kel) {
                                return Kelurahan::where('kecamatan_code', '731211')
                                    ->pluck('name', 'code');
                            }

                            return $kel->pluck('name', 'code');
                        })
                        ->reactive()
                        ->searchable(),
                ]),

            Grid::make(4)
                ->schema([
                    TextInput::make('dusun')
                        ->label('Dusun')
                        ->nullable(),
                    TextInput::make('no_rt')
                        ->label('RT')
                        ->nullable(),
                    TextInput::make('no_rw')
                        ->label('RW')
                        ->nullable(),
                    TextInput::make('kodepos')
                        ->label('Kodepos')
                        ->default('90861')
                        ->required(),
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
