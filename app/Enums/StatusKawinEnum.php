<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusKawinEnum: int implements HasLabel, HasColor
{
    case KAWIN = 1;
    case BELUMKAWIN = 2;
    case CERAI_HIDUP = 3;
    case CERAI_MATI = 4;
    case JANDA = 5;
    case DUDA = 6;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::KAWIN => 'KAWIN',
            self::BELUMKAWIN => 'BELUM KAWIN',
            self::CERAI_HIDUP => 'CERAI HIDUP',
            self::CERAI_MATI => 'CERAI MATI',
            self::JANDA => 'JANDA',
            self::DUDA => 'DUDA',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::KAWIN => 'success',
            self::BELUMKAWIN => 'warning',
            self::CERAI_HIDUP => 'secondary',
            self::CERAI_MATI => 'danger',
            self::JANDA => 'info',
            self::DUDA => 'primary',
        };
    }

//    public function getIcon(): ?string
//    {
//        return match ($this) {
//            self::KAWIN => 'heroicon-o-arrow-path-rounded-square',
//            self::BELUMKAWIN => 'heroicon-o-bolt-slash',
//            self::CERAI_HIDUP => 'heroicon-o-link',
//            self::CERAI_MATI => 'heroicon-o-arrow-down',
//            self::JANDA => 'heroicon-o-document-duplicate',
//            self::DUDA => 'heroicon-o-eye-slash',
//        };
//    }
}
