<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusKawinBpjsEnum: int implements HasColor, HasLabel
{
    case BELUM_KAWIN = 1;
    case KAWIN = 2;
    case JANDA = 3;
    case DUDA = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KAWIN => 'KAWIN',
            self::BELUM_KAWIN => 'BELUM KAWIN',
            self::JANDA => 'JANDA',
            self::DUDA => 'DUDA',
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
