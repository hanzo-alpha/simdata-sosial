<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\StatusAktif;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Traits\HasWidgetShield;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;

class DemografiKpmChart extends ChartWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    protected ?string $heading = 'Komposisi Program Bantuan';

    protected ?string $description = 'Perbandingan jumlah KPM per program bantuan';

    protected static ?int $sort = 10;

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '350px';

    protected function getData(): array
    {
        $kecamatan = $this->pageFilters['kecamatan'] ?? null;
        $kelurahan = $this->pageFilters['kelurahan'] ?? null;

        if (auth()->check() && auth()->user()->instansi_id) {
            $kelurahan = auth()->user()->instansi_id;
            $kecamatan = auth()->user()->instansi?->kecamatan_code;
        }

        $rastra = BantuanRastra::query()
            ->where('status_aktif', StatusAktif::AKTIF)
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->count();

        $ppks = BantuanPpks::query()
            ->where('status_aktif', StatusAktif::AKTIF)
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->count();

        $pkh = BantuanPkh::query()
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->count();

        $bpnt = BantuanBpnt::query()
            ->when($kecamatan, fn(Builder $query) => $query->where('kecamatan', $kecamatan))
            ->when($kelurahan, fn(Builder $query) => $query->where('kelurahan', $kelurahan))
            ->count();

        $total = $rastra + $ppks + $pkh + $bpnt;

        $p_rastra = $total > 0 ? round(($rastra / $total) * 100, 1) : 0;
        $p_ppks = $total > 0 ? round(($ppks / $total) * 100, 1) : 0;
        $p_pkh = $total > 0 ? round(($pkh / $total) * 100, 1) : 0;
        $p_bpnt = $total > 0 ? round(($bpnt / $total) * 100, 1) : 0;

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah KPM',
                    'data' => [$rastra, $ppks, $pkh, $bpnt],
                    'backgroundColor' => [
                        '#3B82F6', // Blue
                        '#F59E0B', // Amber
                        '#EF4444', // Red
                        '#10B981', // Emerald
                    ],
                    'hoverOffset' => 12,
                    'borderWidth' => 0,
                ],
            ],
            'labels' => [
                "Rastra ({$p_rastra}%)",
                "PPKS ({$p_ppks}%)",
                "PKH ({$p_pkh}%)",
                "BPNT ({$p_bpnt}%)",
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(
            <<<JS
        {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 13,
                            weight: '500',
                            family: 'inherit',
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return ' ' + label.split(' (')[0] + ': ' + value.toLocaleString('id-ID') + ' KPM';
                        }
                    }
                }
            },
            cutout: '65%',
            maintainAspectRatio: false,
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
JS,
        );
    }
}
