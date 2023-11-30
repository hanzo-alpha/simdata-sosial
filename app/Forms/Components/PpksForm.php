<?php

namespace App\Forms\Components;

use App\Enums\StatusKondisiRumahEnum;
use App\Models\KriteriaPelayanan;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Wallo\FilamentSelectify\Components\ToggleButton;

class PpksForm extends Field
{
    public ?string $relationship = null;

    protected string $view = 'filament-forms::components.group';

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
                    Select::make('jenis_pelayanan_id')
                        ->relationship('jenis_pelayanan', 'nama_ppks')
                        ->required(),
                    Select::make('jenis_bantuan_id')
                        ->relationship('jenis_bantuan', 'nama_bantuan')
                        ->default(4)
                        ->required(),
                    TableRepeater::make('jenis_ppks')->schema([
                        Select::make('kriteria_ppks')
                            ->options(KriteriaPelayanan::pluck('nama_kriteria', 'id'))
                    ]),
                    TextInput::make('penghasilan_rata_rata')
                        ->numeric(),
                    ToggleButton::make('status_rumah_tinggal'),
                    Select::make('status_kondisi_rumah')
                        ->options(StatusKondisiRumahEnum::class)
                        ->preload()
                        ->lazy(),
                    ToggleButton::make('status_bantuan'),
                ]),
        ];
    }

    public function relationship(string|callable $relationship): static
    {
        $this->relationship = $relationship;

        return $this;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (PpksForm $component, ?Model $record) {
            $ppks = $record?->getRelationValue($this->getRelationship());

            $component->state($ppks ? $ppks->toArray() : [
                'jenis_pelayanan_id' => null,
                'jenis_ppks' => null,
                'penghasilan_rata_rata' => null,
                'jenis_bantuan_id' => null,
                'status_rumah_tinggal' => null,
                'status_kondisi_rumah' => null,
                'anggaran_id' => null,
                'status_bantuan' => null
            ]);
        });

        $this->dehydrated(false);
    }
}
