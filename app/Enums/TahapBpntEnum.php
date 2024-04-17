<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TahapBpntEnum: int implements HasColor, HasIcon, HasLabel
{
    case THP1 = 1;
    case THP2 = 2;
    case THP3 = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::THP1 => 'Tahap 1 & 2',
            self::THP2 => 'Tahap 3 & 4',
            self::THP3 => 'Tahap 5 & 6',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::THP1 => 'success',
            self::THP2 => 'warning',
            self::THP3 => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::THP1 => 'heroicon-o-check-circle',
            self::THP2 => 'heroicon-o-minus-circle',
            self::THP3 => 'heroicon-o-arrow-up-circle',
        };
    }
}
