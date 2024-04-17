<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum KategoriKpmEnum: string implements HasColor, HasIcon, HasLabel
{
    case DYS = 'DYS';
    case LJS = 'LJS';
    case RHS = 'RHS';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DYS => 'DYS',
            self::LJS => 'LJS',
            self::RHS => 'RHS',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::DYS => 'success',
            self::LJS => 'warning',
            self::RHS => 'info',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::DYS => 'heroicon-o-check-circle',
            self::LJS => 'heroicon-o-minus-circle',
            self::RHS => 'heroicon-o-arrow-up-circle',
        };
    }
}
