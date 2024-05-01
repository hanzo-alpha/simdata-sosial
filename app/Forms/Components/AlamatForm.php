<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Model;

final class AlamatForm extends Field
{
    public ?string $relationship = null;

    protected string $view = 'filament-forms::components.group';

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (AlamatForm $component, ?Model $record): void {
            $address = $record?->getRelationValue($this->getRelationship());

            $component->state($address ? $address->toArray() : [
                'provinsi' => '73',
                'alamat' => null,
                'kabupaten' => '7312',
                'kecamatan' => null,
                'kelurahan' => null,
                'no_rt' => null,
                'no_rw' => null,
                'dusun' => null,
                //                'latitude' => null,
                //                'longitude' => null,
                'kodepos' => null,
            ]);
        });

        $this->dehydrated(false);
    }

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

        if (null === $relationship) {
            return;
        }

        if ($address = $relationship->first()) {
            $address->update($state);
        } else {
            $relationship->updateOrCreate($state);
        }

        $record?->touch();
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
            //                            ->lazy(),
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
                    Select::make('provinsi')
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(Provinsi::pluck('name', 'code'))
                        ->default(config('custom.default.kodeprov'))
                        ->afterStateUpdated(function (callable $set): void {
                            $set('kabupaten', null);
                            $set('kecamatan', null);
                            $set('kelurahan', null);
                        }),
                    Select::make('kabupaten')
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function (Get $get) {
                            $kab = Kabupaten::query()->where('provinsi_code', $get('provinsi'));
                            if ( ! $kab) {
                                return Kabupaten::where('provinsi_code', config('custom.default.kodekab'))
                                    ->pluck('name', 'code');
                            }

                            return $kab->pluck('name', 'code');
                        })
                        ->default(config('custom.default.kodekab'))
                        ->afterStateUpdated(function (callable $set): void {
                            $set('kecamatan', null);
                            $set('kelurahan', null);
                        }),
                    Select::make('kecamatan')
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function (Get $get) {
                            $kab = Kecamatan::query()->where('kabupaten_code', $get('kabupaten'));
                            if ( ! $kab) {
                                return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
                                    ->pluck('name', 'code');
                            }

                            return $kab->pluck('name', 'code');
                        })
                        ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                    Select::make('kelurahan')
                        ->required()
                        ->options(function (callable $get) {
                            return Kelurahan::query()->where('kecamatan_code', $get('kecamatan'))?->pluck(
                                'name',
                                'code',
                            );
                        })
                        ->reactive()
                        ->searchable(),
                ]),

            Grid::make(3)
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
                ]),
        ];
    }

    public function getRelationship(): string
    {
        return $this->evaluate($this->relationship) ?? $this->getName();
    }
}
