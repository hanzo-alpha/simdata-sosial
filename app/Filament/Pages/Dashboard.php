<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\StatusAdminEnum;
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

    public function getColumns(): int|array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 3,
        ];
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
                            ->default(fn() => auth()->user()->instansi?->kecamatan_code)
                            ->disabled(fn() => StatusAdminEnum::OPERATOR === auth()->user()->is_admin)
                            ->dehydrated()
                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),

                        Select::make('kelurahan')
                            ->label('Kelurahan')
                            ->options(fn(callable $get) => Kelurahan::query()
                                ->where('kecamatan_code', $get('kecamatan'))
                                ->pluck('name', 'code'))
                            ->default(fn() => auth()->user()->instansi_id)
                            ->disabled(fn() => StatusAdminEnum::OPERATOR === auth()->user()->is_admin)
                            ->dehydrated()
                            ->native(false)
                            ->live()
                            ->searchable(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }
}
