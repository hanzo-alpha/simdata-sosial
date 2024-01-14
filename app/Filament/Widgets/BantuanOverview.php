<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Kenepa\MultiWidget\MultiWidget;

final class BantuanOverview extends MultiWidget
{
    use HasWidgetShield;

    public array $widgets = [
        BantuanBpjsOverview::class,
        BantuanRastraOverview::class,
        BantuanPkhOverview::class,
        BantuanBpntOverview::class,
        BantuanPpksOverview::class,
    ];
    //
    //    public function shouldPersistMultiWidgetTabsInSession(): bool
    //    {
    //        return true;
    //    }

}
