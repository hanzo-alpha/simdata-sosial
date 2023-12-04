<?php

namespace App\Forms\Components;

use App\Models\JenisBantuan;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BantuanForm extends Field
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
            Select::make('jenis_bantuan_id')
                ->required()
                ->searchable()
                ->relationship(
                    name: 'jenis_bantuan',
                    titleAttribute: 'alias',
                    modifyQueryUsing: fn(Builder $query) => $query->whereNotIn('id', [1, 2])
                )
//                                ->getOptionLabelFromRecordUsing(function ($record) {
//                                    return '<strong>' . $record->alias . '</strong><br>' . $record->nama_bantuan;
//                                })->allowHtml()
                ->preload()
                ->default(4)
                ->lazy()
                ->live(true)
                ->afterStateUpdated(
                    fn(Set $set, JenisBantuan $bantuan, $state) => $set(
                        'nama_bantuan', $bantuan->find($state)->alias
                    )
                )
                ->native(false)
                ->optionsLimit(20),
            TextInput::make('nama_bantuan')
                ->hidden()
                ->dehydrated()
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

        $this->afterStateHydrated(function (BantuanForm $component, ?Model $record) {
            $address = $record?->getRelationValue($this->getRelationship());

            $component->state($address ? $address->toArray() : [
                'jenis_bantuan_id' => null,
                'nama_bantuan' => null,
                'alias' => null,
                'deskripsi' => null,
            ]);
        });

        $this->dehydrated(false);
    }
}
