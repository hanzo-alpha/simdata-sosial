<?php

namespace App\Forms\Components;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class AddressForm extends Field
{
//    protected string $view = 'forms.components.address-form';
    public $relationship = null;
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
                    TextInput::make('alamat')
                        ->label('Alamat'),
                ]),

            Grid::make(2)
                ->schema([
                    Select::make('provinsi')
                        ->searchable()
                        ->options(Provinsi::pluck('name', 'code'))
                        ->preload()
                        ->live(true)
                        ->optionsLimit(20)
                        ->label('Provinsi'),
                    Select::make('kabupaten')
                        ->searchable()
                        ->options(Kabupaten::pluck('name', 'code'))
                        ->preload()
                        ->live(true)
                        ->optionsLimit(20)
                        ->label('Kabupaten'),
                ]),

            Grid::make(2)
                ->schema([
                    Select::make('kecamatan')
                        ->searchable()
                        ->options(Kecamatan::pluck('name', 'code'))
                        ->preload()
                        ->live(true)
                        ->optionsLimit(20)
                        ->label('Kecamatan'),
                    Select::make('kelurahan')
                        ->searchable()
                        ->options(Kelurahan::pluck('name', 'code'))
                        ->preload()
                        ->live(true)
                        ->optionsLimit(20)
                        ->label('Kelurahan'),
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

        $this->afterStateHydrated(function (AddressForm $component, ?Model $record) {
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
