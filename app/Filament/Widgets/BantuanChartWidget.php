<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanRastra;
use App\Models\Kecamatan;
use App\Models\UsulanPengaktifanTmt;
use Filament\Widgets\ChartWidget;
use Illuminate\Database\Eloquent\Builder;

class BantuanChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Bantuan Statistik';
    protected static ?string $maxHeight = '300px';
    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $results = [];
        $pkhresults = [];
        $bpntresults = [];
        $ppksresults = [];
        $rastraresults = [];

        $kec = Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))->pluck('name', 'code');
        foreach ($kec as $key => $item) {
            $results[$item] = UsulanPengaktifanTmt::where('kecamatan', 'like', $key)->get()->count();
        }

        foreach ($kec as $key => $item) {
            $pkhresults[$item] = BantuanPkh::where('kecamatan', 'like', $key)->get()->count();
        }

        foreach ($kec as $key => $item) {
            $bpntresults[$item] = BantuanBpnt::where('kecamatan', 'like', $key)->get()->count();
        }

        foreach ($kec as $key => $item) {
            $rastraresults[$item] = BantuanRastra::with(['alamat'])->whereHas('alamat',
                fn(Builder $query) => $query->where('kecamatan', $item))
                ->get()
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bantuan BPJS',
//                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'data' => array_values($results),
                ],
                [
                    'label' => 'Bantuan PKH',
                    'data' => array_values($pkhresults),
                ],
                [
                    'label' => 'Bantuan BPNT',
                    'data' => array_values($bpntresults),
                ],
                [
                    'label' => 'Bantuan PPKS',
                    'data' => array_values($ppksresults),
                ],
                [
                    'label' => 'Bantuan RASTRA',
                    'data' => array_values($rastraresults),
                ],
            ],
//            'labels' => $data->map(fn(TrendValue $value) => $value->date),
            'labels' => array_keys($results),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
