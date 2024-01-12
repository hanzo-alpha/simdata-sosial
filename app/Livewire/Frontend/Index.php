<?php

namespace App\Livewire\Frontend;

use Akaunting\Apexcharts\Chart;
use App\Models\BantuanBpjs;
use App\Models\BantuanBpnt;
use App\Models\BantuanPkh;
use App\Models\BantuanPpks;
use App\Models\BantuanRastra;
use App\Models\JenisBantuan;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $bantuan = [
            'rastra' => BantuanRastra::count(),
            'bpjs' => BantuanBpjs::count(),
            'pkh' => BantuanPkh::count(),
            'bpnt' => BantuanBpnt::count(),
            'ppks' => BantuanPpks::count(),
        ];

        $chart = (new Chart)->setType('donut')
            ->setWidth('100%')
            ->setHeight(500)
//            ->setLegendFontFamily('Poppins')
            ->setLegendFontSize('18')
            ->setLabels(['Program BPJS', 'Program RASTRA', 'Program PKH', 'Program BPNT', 'Program PPKS'])
            ->setDataset('Jumlah KPM Per Program Bantuan', 'donut', [
                $bantuan['bpjs'],
                $bantuan['rastra'],
                $bantuan['pkh'],
                $bantuan['bpnt'],
                $bantuan['ppks']
            ]);

        return view('livewire.frontend.index', compact('chart', 'bantuan'));
    }
}
