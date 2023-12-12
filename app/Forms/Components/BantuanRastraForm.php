<?php

namespace App\Forms\Components;

use App\Enums\AlasanEnum;
use App\Enums\StatusRastra;
use App\Models\Family;
use App\Models\JenisBantuan;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BantuanRastraForm extends Field
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
            Select::make('status_rastra')
                ->label('Status Rastra')
                ->enum(StatusRastra::class)
                ->options(StatusRastra::class)
                ->default(StatusRastra::BARU)
                ->live()
                ->preload(),

            Select::make('pengganti_rastra.keluarga_id')
                ->label('Keluarga Yang Diganti')
                ->required()
//                ->relationship('bantuan_rastra.family','nama_lengkap')
                ->options(Family::query()->pluck('nama_lengkap', 'id'))
                ->searchable(['nama_lengkap', 'nik', 'nokk'])
//                ->options(self::where('status_rastra', StatusRastra::BARU)->pluck('nama_lengkap', 'id'))
//                ->getOptionLabelFromRecordUsing(function ($record) {
//                    return '<strong>' . $record->family->nama_lengkap . '</strong><br>' . $record->nik;
//                })->allowHtml()
                ->optionsLimit(15)
                ->lazy()
                ->visible(fn(Get $get) => $get('status_rastra') === StatusRastra::PENGGANTI)
                ->preload(),

            Select::make('pengganti_rastra.alasan_dikeluarkan')
                ->searchable()
                ->options(AlasanEnum::class)
                ->enum(AlasanEnum::class)
                ->native(false)
                ->preload()
                ->lazy()
                ->required()
                ->visible(fn(Get $get) => $get('status_rastra') === StatusRastra::PENGGANTI)
                ->default(AlasanEnum::PINDAH)
                ->optionsLimit(15),
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

        $this->afterStateHydrated(function (BantuanRastraForm $component, ?Model $record) {
            $bantuan = $record?->getRelationValue($this->getRelationship());

            $component->state($bantuan ? $bantuan->toArray() : [
                'jenis_bantuan_id' => 3,
                'nama_bantuan' => null,
            ]);
        });

        $this->dehydrated(false);
    }
}
