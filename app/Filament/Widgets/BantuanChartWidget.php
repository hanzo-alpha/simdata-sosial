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
    protected static ?string $heading = 'Bantuan Statistik Per Kecamatan';
    protected static ?string $maxHeight = '300px';
    protected static ?string $pollingInterval = null;
    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }

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
//                    'backgroundColor' => '#9BD0F5',
//                    'borderColor' => '#36A2EB'
                ],
                [
                    'label' => 'Bantuan PKH',
                    'data' => array_values($pkhresults),
//                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FFB1C1'
                ],
                [
                    'label' => 'Bantuan BPNT',
                    'data' => array_values($bpntresults),
//                    'backgroundColor' => '#9BD0F5',
                    'borderColor' => '#36A2EB'
                ],
                [
                    'label' => 'Bantuan PPKS',
                    'data' => array_values($ppksresults),
                    'borderColor' => '#e8c838'
                ],
                [
                    'label' => 'Bantuan RASTRA',
                    'data' => array_values($rastraresults),
                    'borderColor' => '#20d669'
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
