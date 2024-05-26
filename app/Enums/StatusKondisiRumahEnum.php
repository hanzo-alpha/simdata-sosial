<?php

declare(strict_types=1);

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
            self::BAIK => 'heroicon-o-arrow-up',
            self::SEDANG => 'heroicon-o-arrow-right',
            self::RUSAK => 'heroicon-o-arrow-down-right',
            self::RUSAK_BERAT => 'heroicon-o-arrow-down',
        };
    }
}
