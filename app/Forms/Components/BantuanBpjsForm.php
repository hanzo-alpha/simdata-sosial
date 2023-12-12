<?php

namespace App\Forms\Components;

use App\Enums\AlasanEnum;
use App\Enums\StatusBpjsEnum;
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

class BantuanBpjsForm extends Field
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
            Select::make('status_bpjs')
                ->label('Status BPJS')
                ->options(StatusBpjsEnum::class)
                ->default(StatusBpjsEnum::PENGAKTIFAN)
                ->lazy()
                ->preload(),
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

        $this->afterStateHydrated(function (BantuanBpjsForm $component, ?Model $record) {
            $bantuan = $record?->getRelationValue($this->getRelationship());

            $component->state($bantuan ? $bantuan->toArray() : [
                'status_bpjs' => StatusBpjsEnum::PENGAKTIFAN
            ]);
        });

        $this->dehydrated(false);
    }
}
