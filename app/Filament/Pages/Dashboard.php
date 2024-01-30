<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersAction;
    use HasFiltersForm;
    use HasPageShield;

    //    public function filtersForm(Form $form): Form
    //    {
    //        return $form
    //            ->schema([
    //                Section::make()
    //                    ->schema([
    //                        //                        DateRangePicker::make('daterange')
    //                        //                            ->label('Rentang Waktu')
    //                        //                            ->timezone('Asia/Makassar')
    //                        //                            ->displayFormat('d/M/Y')
    //                        //                            ->format('Y-m-d H:i:s'),
    //                        Select::make('kecamatan')
    //                            ->required()
    //                            ->searchable()
    //                            ->reactive()
    //                            ->options(function () {
    //                                $kab = Kecamatan::query()
    //                                    ->where('kabupaten_code', config('custom.default.kodekab'));
    //                                if ( ! $kab) {
    //                                    return Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
    //                                        ->pluck('name', 'code');
    //                                }
    //
    //                                return $kab->pluck('name', 'code');
    //                            })
    //                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),
    //
    //                        Select::make('kelurahan')
    //                            ->required()
    //                            ->options(function (callable $get) {
    //                                return Kelurahan::query()->where('kecamatan_code', $get('kecamatan'))
    //                                    ?->pluck('name', 'code');
    //                            })
    //                            ->reactive()
    //                            ->searchable(),
    //                    ])
    //                    ->columns(2),
    //            ]);
    //    }

    //    protected function getHeaderActions(): array
    //    {
    //        return [
    //            FilterAction::make()
    //                ->form([
    //                    DatePicker::make('startDate')
    //                        ->displayFormat('d/M/Y'),
    //                    DatePicker::make('endDate')
    //                        ->displayFormat('d/M/Y'),
    //                ]),
    //        ];
    //    }
}
