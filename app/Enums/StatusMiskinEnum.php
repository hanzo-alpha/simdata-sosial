<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusMiskinEnum: string implements HasColor, HasIcon, HasLabel
{
    case MISKIN = 'MISKIN';
    case RENTAN_MISKIN = 'RENTAN MISKIN';
    case MAMPU = 'MAMPU';
    case MISKIN_EKSTRIM = 'MISKIN EKSTRIM';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MISKIN => 'MISKIN',
            self::RENTAN_MISKIN => 'RENTAN MISKIN',
            self::MAMPU => 'MAMPU',
            self::MISKIN_EKSTRIM => 'MISKIN EKSTRIM',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::MISKIN => 'info',
            self::RENTAN_MISKIN => 'warning',
            self::MAMPU => 'danger',
            self::MISKIN_EKSTRIM => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::MISKIN => 'heroicon-o-arrow-path-rounded-square',
            self::RENTAN_MISKIN => 'heroicon-o-user-minus',
            self::MAMPU => 'heroicon-o-server-stack',
            self::MISKIN_EKSTRIM => 'heroicon-o-check-circle',
        };
    }
}
