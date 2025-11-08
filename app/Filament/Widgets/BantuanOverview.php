<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\BantuanBpntResource\Widgets\BantuanBpntOverview;
use App\Filament\Resources\BantuanPkhResource\Widgets\BantuanPkhOverview;
use App\Filament\Resources\BantuanPpksResource\Widgets\BantuanPpksOverview;
use App\Filament\Resources\BantuanRastraResource\Widgets\BantuanRastraOverview;
use App\Filament\Resources\RekapPenerimaBpjsResource\Widgets\RekapPenerimaBpjsOverview;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use VodafoneZiggoNL\MultiWidget\MultiWidget;

class BantuanOverview extends MultiWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    public array $widgets = [
        //        BantuanBpjsOverview::class,
        RekapPenerimaBpjsOverview::class,
        BantuanRastraOverview::class,
        BantuanPkhOverview::class,
        BantuanBpntOverview::class,
        BantuanPpksOverview::class,
    ];
}
