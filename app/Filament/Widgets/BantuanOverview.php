<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\BantuanBpntResource\Widgets\BantuanBpntOverview;
use App\Filament\Resources\BantuanPkhResource\Widgets\BantuanPkhOverview;
use App\Filament\Resources\BantuanPpksResource\Widgets\BantuanPpksOverview;
use App\Filament\Resources\BantuanRastraResource\Widgets\BantuanRastraOverview;
use App\Filament\Resources\RekapPenerimaBpjsResource\Widgets\RekapPenerimaBpjsOverview;
use App\Traits\HasWidgetShield;
use VodafoneZiggoNL\MultiWidget\MultiWidget;

class BantuanOverview extends MultiWidget
{
    use HasWidgetShield;

    public array $widgets = [
        RekapPenerimaBpjsOverview::class,
        BantuanRastraOverview::class,
        BantuanPkhOverview::class,
        BantuanBpntOverview::class,
        BantuanPpksOverview::class,
    ];

    protected int|string|array $columnSpan = 'full';

    protected int|array|null $columns = 1;

    public function getColumnSpan(): int|string|array
    {
        return 12;
    }

    public function shouldPersistMultiWidgetTabsInSession(): bool
    {
        return true;
    }

}
