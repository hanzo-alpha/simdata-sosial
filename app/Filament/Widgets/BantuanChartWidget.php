<?php

namespace App\Filament\Widgets;

use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\Kecamatan;
use App\Models\UsulanPengaktifanTmt;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class BantuanChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Bantuan Statistik Per Kecamatan';
    protected static ?string $maxHeight = '400px';
    protected static ?string $pollingInterval = null;
//    protected int|string|array $columnSpan = 'full';
    protected int|string|array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
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
            $bpjsresults[$item] = UsulanPengaktifanTmt::where('kecamatan', 'like', $key)
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                    return $query->where('kecamatan', $kecamatan);
                })
                ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                    return $query->where('kelurahan', $kelurahan);
                })
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
                ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                    return $query->where('kecamatan', $kecamatan);
                })
                ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                    return $query->where('kelurahan', $kelurahan);
                })
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
                ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                    return $query->where('kecamatan', $kecamatan);
                })
                ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                    return $query->where('kelurahan', $kelurahan);
                })
                ->get()->count();
        }

        foreach ($kec as $key => $item) {
            $ppksresults[$item] = BantuanPpks::with(['alamat'])->whereHas('alamat',
                fn(Builder $query) => $query->where('kecamatan', $item))
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                    return $query->whereHas('alamat', function (Builder $query) use ($kecamatan) {
                        return $query->whereHas('kec', function (Builder $query) use ($kecamatan) {
                            return $query->where('code', $kecamatan);
                        });
                    });
                })
                ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                    return $query->whereHas('alamat', function (Builder $query) use ($kelurahan) {
                        return $query->whereHas('kel', function (Builder $query) use ($kelurahan) {
                            return $query->where('code', $kelurahan);
                        });
                    });
                })
                ->get()->count();
        }

        foreach ($kec as $key => $item) {
            $rastraresults[$item] = BantuanRastra::with(['alamat'])
//                ->when($dateRange, function (Builder $query) use ($dateRange) {
//                    return $query->whereDate('created_at', $dateRange);
//                    $dates = explode('-', $dateRange);
//                    return $query
//                        ->whereDate('created_at', '<=', $dates[0])
//                        ->whereDate('created_at', '>=', $dates[1]);
//                })
                ->when($kecamatan, function (Builder $query) use ($kecamatan) {
                    return $query->whereHas('alamat', function (Builder $query) use ($kecamatan) {
                        return $query->whereHas('kec', function (Builder $query) use ($kecamatan) {
                            return $query->where('code', $kecamatan);
                        });
                    });
                })
                ->when($kelurahan, function (Builder $query) use ($kelurahan) {
                    return $query->whereHas('alamat', function (Builder $query) use ($kelurahan) {
                        return $query->whereHas('kel', function (Builder $query) use ($kelurahan) {
                            return $query->where('code', $kelurahan);
                        });
                    });
                })
//                ->whereHas('alamat',
//                    fn(Builder $query) => $query->where('kecamatan', $item))
//                ->get()
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
            'labels' => array_keys($bpjsresults),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function getColumns(): int|string|array
    {
        return 2;
    }
}
