<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm;
    use HasPageShield;

    public function getMaxContentWidth(): \Filament\Support\Enums\Width|string|null
    {
        return \Filament\Support\Enums\Width::Full;
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('kecamatan')
                            ->label('Kecamatan')
                            ->searchable()
                            ->live()
                            ->native(false)
                            ->options(Kecamatan::query()
                                ->where('kabupaten_code', setting('app.kodekab'))
                                ->pluck('name', 'code'))
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null))
                            ->columnSpanFull(),

                        Select::make('kelurahan')
                            ->label('Kelurahan')
                            ->options(fn(callable $get) => Kelurahan::query()
                                ->where('kecamatan_code', $get('kecamatan'))
                                ->pluck('name', 'code'))
                            ->native(false)
                            ->live()
                            ->searchable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
