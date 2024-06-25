<?php

declare(strict_types=1);

namespace App\Livewire\Frontend;

use Akaunting\Apexcharts\Chart;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\RekapPenerimaBpjs;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Index extends Component
{
    public function render(): View|Application|Factory
    {
        $bantuan = $this->renderBantuan();
        $chart = $this->renderChart($bantuan);

        return view('livewire.frontend.index', compact('chart', 'bantuan'));
    }

    protected function renderBantuan(): array
    {
        return [
            'rastra' => BantuanRastra::count(),
            'bpjs' => (int) RekapPenerimaBpjs::sum('jumlah'),
            'pkh' => BantuanPkh::count(),
            'bpnt' => BantuanBpnt::count(),
            'ppks' => BantuanPpks::count(),
            'angka_kemiskinan' => (int) setting('app.angka_kemiskinan') ?? 0,
        ];
    }

    protected function renderChart(array $bantuan): Chart
    {
        return (new Chart())->setType('donut')
            ->setWidth('100%')
            ->setHeight(500)
            ->setLegendFontFamily('Be Vietnam Pro')
            ->setLegendFontSize('18')
            ->setLegendPosition('bottom')
            ->setLabels([
                'RASTRA', 'BPJS', 'PKH', 'BPNT', 'PPKS', 'Angka Kemiskinan',
            ])
            ->setDataset('Jumlah KPM Per Program Bantuan', 'donut', [
                $bantuan['rastra'],
                $bantuan['bpjs'],
                $bantuan['pkh'],
                $bantuan['bpnt'],
                $bantuan['ppks'],
                $bantuan['angka_kemiskinan'],
            ]);
    }
}
