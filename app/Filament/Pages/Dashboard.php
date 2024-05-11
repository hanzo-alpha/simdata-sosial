<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasPageShield;

    //    public function filtersForm(Form $form): Form
    //    {
    //        return $form
    //            ->schema([
    //                Section::make()
    //                    ->schema([
    //                        //                        Select::make('tipe')
    //                        //                            ->label('Berdasarkan')
    //                        //                            ->options([
    //                        //                                'kelurahan' => 'Kelurahan',
    //                        //                                'kecamatan' => 'Kecamatan',
    //                        //                            ])
    //                        //                            ->default('kecamatan')
    //                        //                            ->preload()
    //                        //                            ->native(false)
    //                        //                            ->live(onBlur: true),
    //                        Select::make('kecamatan')
    //                            ->searchable()
    //                            ->live(onBlur: true)
    //                            ->native(false)
    //                            ->options(function () {
    //                                $kab = Kecamatan::query()
    //                                    ->where('kabupaten_code', config('custom.default.kodekab'));
    //                                if (!$kab) {
    //                                    return Kecamatan::where(
    //                                        'kabupaten_code',
    //                                        config('custom.default.kodekab')
    //                                    )
    //                                        ->pluck('name', 'code');
    //                                }
    //
    //                                return $kab->pluck('name', 'code');
    //                            })
    ////                            ->hidden(fn(Get $get) => 'kelurahan' === $get('tipe'))
    ////                            ->visible(fn(Get $get) => 'kecamatan' === $get('tipe'))
    ////                            ->dehydrated()
    //                            ->afterStateUpdated(fn(callable $set) => $set('kelurahan', null)),
    //
    //                        Select::make('kelurahan')
    //                            ->options(function (callable $get) {
    //                                return Kelurahan::query()->where('kecamatan_code', $get('kecamatan'))
    //                                    ?->pluck('name', 'code');
    //                            })
    ////                            ->hidden(fn(Get $get) => 'kecamatan' === $get('tipe'))
    ////                            ->visible(fn(Get $get) => 'kelurahan' === $get('kelurahan'))
    ////                            ->dehydrated()
    //                            ->native(false)
    //                            ->live(onBlur: true)
    //                            ->searchable(),
    //                    ])
    //                    ->columns(2),
    //            ]);
    //    }

}
