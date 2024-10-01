<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SatuanEnum: string implements HasColor, HasIcon, HasLabel
{
    case KG = 'KG';
    case UNIT = 'UNIT';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::KG => 'KG',
            self::UNIT => 'UNIT',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::KG => 'success',
            self::UNIT => 'warning',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::KG => 'heroicon-o-check-circle',
            self::UNIT => 'heroicon-o-minus-circle',
        };
    }
}
