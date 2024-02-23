<?php

namespace App\Livewire\Frontend;

use Akaunting\Apexcharts\Chart;
use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
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
            'bpjs' => BantuanBpjs::count(),
            'pkh' => BantuanPkh::count(),
            'bpnt' => BantuanBpnt::count(),
            'ppks' => BantuanPpks::count(),
        ];
    }

    protected function renderChart(array $bantuan): Chart
    {
        return (new Chart())->setType('donut')
            ->setWidth('100%')
            ->setHeight(500)
            ->setLegendFontFamily('Poppins')
            ->setLegendFontSize('18')
            ->setLegendPosition('bottom')
            ->setLabels(['Program BPJS', 'Program RASTRA', 'Program PKH', 'Program BPNT', 'Program PPKS'])
            ->setDataset('Jumlah KPM Per Program Bantuan', 'donut', [
                $bantuan['bpjs'],
                $bantuan['rastra'],
                $bantuan['pkh'],
                $bantuan['bpnt'],
                $bantuan['ppks'],
            ]);
    }
}
