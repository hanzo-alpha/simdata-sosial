<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum KeteranganDistribusiEnum: int implements HasColor, HasIcon, HasLabel
{
    case DISTRIBUTED = 1;
    case NOT_DISTRIBUTED = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DISTRIBUTED => 'TERDISTRIBUSI',
            self::NOT_DISTRIBUTED => 'TIDAK TERDISTRIBUSI',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DISTRIBUTED => 'success',
            self::NOT_DISTRIBUTED => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DISTRIBUTED => 'heroicon-o-check-circle',
            self::NOT_DISTRIBUTED => 'heroicon-o-minus-circle',
        };
    }
}
