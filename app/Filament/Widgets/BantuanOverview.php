<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Kenepa\MultiWidget\MultiWidget;

class BantuanOverview extends MultiWidget
{
    use HasWidgetShield;
    use InteractsWithPageFilters;

    public array $widgets = [
        BantuanBpjsOverview::class,
        BantuanRastraOverview::class,
        BantuanPkhOverview::class,
        BantuanBpntOverview::class,
        BantuanPpksOverview::class,
    ];

    public function shouldPersistMultiWidgetTabsInSession(): bool
    {
        return true;
    }
}
