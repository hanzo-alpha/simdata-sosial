<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum StatusKondisiRumahEnum: int implements HasColor, HasIcon, HasLabel
{
    case BAIK = 1;
    case SEDANG = 2;
    case RUSAK = 3;
    case RUSAK_BERAT = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BAIK => 'BAIK',
            self::SEDANG => 'SEDANG',
            self::RUSAK => 'RUSAK',
            self::RUSAK_BERAT => 'RUSAK BERAT',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::BAIK => 'info',
            self::SEDANG => 'warning',
            self::RUSAK => 'danger',
            self::RUSAK_BERAT => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::BAIK => 'heroicon-o-arrow-path-rounded-square',
            self::SEDANG => 'heroicon-o-user-minus',
            self::RUSAK => 'heroicon-o-server-stack',
            self::RUSAK_BERAT => 'heroicon-o-check-circle',
        };
    }
}
