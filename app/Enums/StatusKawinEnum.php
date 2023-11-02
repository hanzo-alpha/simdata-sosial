<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusKawinEnum: string implements HasLabel, HasIcon, HasColor
{
    case KAWIN = 'K';
    case BELUMKAWIN = 'BK';
    case CERAI_HIDUP = 'CH';
    case CERAI_MATI = 'CM';
    case JANDA = 'J';
    case DUDA = 'D';


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

    public function getIcon(): ?string
    {
        return match ($this) {
            self::KAWIN => 'heroicon-o-arrow-path-rounded-square',
            self::BELUMKAWIN => 'heroicon-o-bolt-slash',
            self::CERAI_HIDUP => 'heroicon-o-link',
            self::CERAI_MATI => 'heroicon-o-arrow-down',
            self::JANDA => 'heroicon-o-document-duplicate',
            self::DUDA => 'heroicon-o-eye-slash',
        };
    }
}
