<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\Kecamatan;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BantuanChartWidget extends ChartWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Statistik Program Bantuan Per Kecamatan';

    protected static ?string $maxHeight = '400px';

    protected static ?string $pollingInterval = null;

    //    protected int|string|array $columnSpan = 'full';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];

    protected static function getQuery(Model $model, array $filter): Builder
    {
        return $model::query()
            ->when($filter['kecamatan'], fn(Builder $query) => $query->whereHas(
                'kec',
                fn(Builder $query) => $query->where('code', $filter['kecamatan'])
                    ->orWhere('name', 'like', '%'.$filter['kecamatan'].'%')
            ))
            ->when($filter['kelurahan'], fn(Builder $query) => $query->whereHas(
                'kel',
                fn(Builder $query) => $query->where('code', $filter['kelurahan'])
                    ->orWhere('name', 'like', '%'.$filter['kelurahan'].'%')
            ));
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }

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
        $bpjsresults = [];
        $pkhresults = [];
        $bpntresults = [];
        $ppksresults = [];
        $rastraresults = [];

        $dateRange = $this->filters['daterange'] ?? null;
        $kecamatan = $this->filters['kecamatan'] ?? null;
        $kelurahan = $this->filters['kelurahan'] ?? null;

        $kec = Kecamatan::where('kabupaten_code', config('custom.default.kodekab'))
            ->pluck('name', 'code');

        foreach ($kec as $key => $item) {
            //            $kel = Kelurahan::where('kecamatan_code', $key)->pluck('name','code');
            //            foreach ($kel as $k => $v) {
            //                $bpjsresults[$item] = UsulanPengaktifanTmt::where('kecamatan', 'like', $key)
            ////                ->when($dateRange, function (Builder $query) use ($dateRange) {
            ////                    $dates = explode('-', $dateRange);
            ////                    return $query
            ////                        ->whereDate('created_at', '<=', $dates[0])
            ////                        ->whereDate('created_at', '>=', $dates[1]);
            ////                })
            //                    ->when($kecamatan, function (Builder $query) use ($kecamatan) {
            //                        return $query->where('kecamatan', $kecamatan);
            //                    })
            //                    ->when($kelurahan, function (Builder $query) use ($kelurahan) {
            //                        return $query->where('kelurahan', $kelurahan);
            //                    })
            //                    ->get()->count();
            //            }
            $bpjsresults[$item] = BantuanBpjs::where('kecamatan', 'like', $key)
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
                ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
                ->get()->count();
        }

        foreach ($kec as $key => $item) {
            $pkhresults[$item] = BantuanPkh::where('kecamatan', 'like', $key)
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
                ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
                ->get()->count();
        }

        foreach ($kec as $key => $item) {
            $bpntresults[$item] = BantuanBpnt::where('kecamatan', 'like', $key)
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
                ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
                ->get()->count();
        }

        foreach ($kec as $key => $item) {
            $ppksresults[$item] = BantuanPpks::with(['kec', 'kel'])->whereHas(
                'alamat',
                fn(Builder $query) => $query->where('kecamatan', $item)
            )
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, fn(Builder $query) => $query->whereHas(
                    'kec',
                    fn(Builder $query) => $query->where('code', $kecamatan)
                        ->orWhere('name', 'like', '%'.$kecamatan.'%')
                ))
                ->when($kelurahan, fn(Builder $query) => $query->whereHas(
                    'kel',
                    fn(Builder $query) => $query->where('code', $kelurahan)
                        ->orWhere('name', 'like', '%'.$kelurahan.'%')
                ))
                ->get()->count();
        }

        foreach ($kec as $key => $item) {
            $rastraresults[$item] = BantuanRastra::with(['kec', 'kel'])
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    return $query->whereDate('created_at', $dateRange);
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, fn(Builder $query) => $query->whereHas(
                    'kec',
                    fn(Builder $query) => $query->where('code', $kecamatan)
                        ->orWhere('name', 'like', '%'.$kecamatan.'%')
                ))
                ->when($kelurahan, fn(Builder $query) => $query->whereHas(
                    'kel',
                    fn(Builder $query) => $query->where('code', $kelurahan)
                        ->orWhere('name', 'like', '%'.$kelurahan.'%')
                ))
                ->get()
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Bantuan BPJS',
                    //                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'data' => array_values($bpjsresults),
                    //                    'backgroundColor' => '#9BD0F5',
                    //                    'borderColor' => '#36A2EB'
                ],
                [
                    'label' => 'Bantuan PKH',
                    'data' => array_values($pkhresults),
                    //                    'backgroundColor' => '#FF6384',
                    'borderColor' => '#FFB1C1',
                ],
                [
                    'label' => 'Bantuan BPNT',
                    'data' => array_values($bpntresults),
                    //                    'backgroundColor' => '#9BD0F5',
                    'borderColor' => '#36A2EB',
                ],
                [
                    'label' => 'Bantuan PPKS',
                    'data' => array_values($ppksresults),
                    'borderColor' => '#e8c838',
                ],
                [
                    'label' => 'Bantuan RASTRA',
                    'data' => array_values($rastraresults),
                    'borderColor' => '#20d669',
                ],
            ],
            //            'labels' => $data->map(fn(TrendValue $value) => $value->date),
            'labels' => array_keys($bpjsresults),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
