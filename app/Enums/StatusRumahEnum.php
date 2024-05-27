<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusRumahEnum: int implements HasColor, HasIcon, HasLabel
{
    case MILIK_SENDIRI = 1;
    case MENUMPANG = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MILIK_SENDIRI => 'Milik Sendiri',
            self::MENUMPANG => 'Menumpang',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::MILIK_SENDIRI => 'info',
            self::MENUMPANG => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::MILIK_SENDIRI => 'heroicon-o-arrow-up-circle',
            self::MENUMPANG => 'heroicon-o-arrow-down-circle',
        };
    }
}
