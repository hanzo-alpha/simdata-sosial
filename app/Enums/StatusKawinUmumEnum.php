<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusKawinUmumEnum: int implements HasColor, HasLabel
{
    case KAWIN_TERCATAT = 1;
    case KAWIN_BELUM_TERCATAT = 2;
    case BELUM_KAWIN = 3;
    case CERAI_HIDUP = 4;
    case CERAI_MATI = 5;
    case CERAI_BELUM_TERCATAT = 6;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KAWIN_TERCATAT => 'KAWIN TERCATAT',
            self::KAWIN_BELUM_TERCATAT => 'KAWIN BELUM TERCATAT',
            self::BELUM_KAWIN => 'BELUM KAWIN',
            self::CERAI_HIDUP => 'CERAI HIDUP',
            self::CERAI_MATI => 'CERAI MATI',
            self::CERAI_BELUM_TERCATAT => 'CERAI BELUM TERCATAT',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::KAWIN_TERCATAT => 'primary',
            self::KAWIN_BELUM_TERCATAT => 'warning',
            self::BELUM_KAWIN => 'danger',
            self::CERAI_HIDUP => 'success',
            self::CERAI_MATI => 'info',
            self::CERAI_BELUM_TERCATAT => 'gray',
        };
    }

    //    public function getIcon(): ?string
    //    {
    //        return match ($this) {
    //            self::KAWIN_TERCATAT => 'heroicon-o-arrow-path-rounded-square',
    //            self::KAWIN_BELUM_TERCATAT => 'heroicon-o-document-duplicate',
    //            self::BELUM_KAWIN => 'heroicon-o-bolt-slash',
    //            self::CERAI_HIDUP => 'heroicon-o-link',
    //            self::CERAI_MATI => 'heroicon-o-arrow-down',
    //        };
    //    }
}
