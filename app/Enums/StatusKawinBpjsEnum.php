<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusKawinBpjsEnum: int implements HasLabel, HasColor
{
    case KAWIN = 1;
    case BELUM_KAWIN = 2;
    case JANDA = 3;
    case DUDA = 4;


    public function getLabel(): ?string
    {
        return match ($this) {
            self::KAWIN => 'Kawin',
            self::BELUM_KAWIN => 'Belum Kawin',
            self::JANDA => 'Janda',
            self::DUDA => 'Duda',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::KAWIN => 'primary',
            self::BELUM_KAWIN => 'danger',
            self::JANDA => 'warning',
            self::DUDA => 'info',
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
